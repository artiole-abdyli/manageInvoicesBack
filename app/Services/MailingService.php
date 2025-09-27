<?php

namespace App\Services;

use App\Mail\MailingMessage;
use App\Models\Mailings;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailingService
{
    protected Mailings $mailings;

    public function __construct(Mailings $mailings)
    {
        $this->mailings = $mailings;
    }

    public function listOfMailings()
    {
        $mailings = $this->mailings
            ->newQuery()
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $mailings,
            'code' => 200,
            'message' => 'Mailings retrieved successfully',
        ]);
    }

    public function showMailing(int|string $id)
    {
        $mailing = $this->mailings->findOrFail($id);

        return response()->json([
            'data' => $mailing,
            'code' => 200,
            'message' => 'Mailing retrieved successfully',
        ]);
    }

    public function createMailing(array $payload, bool $sendNow = true)
    {
        $preparedPayload = [];

        try {
            $preparedPayload = $this->normaliseDate($payload);

            if ($sendNow) {
                $this->sendMail($preparedPayload);
            }

            $mailing = $this->mailings->create($preparedPayload);

            return response()->json([
                'data' => $mailing,
                'code' => 201,
                'message' => 'Mailing created successfully',
            ], 201);
        } catch (\Throwable $exception) {
            Log::error('mailings.create_failed', [
                'error' => $exception->getMessage(),
                'payload' => Arr::except($preparedPayload, ['message']),
            ]);

            return response()->json([
                'message' => 'Failed to create mailing',
                'code' => 500,
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function updateMailing(int|string $id, array $payload, bool $sendNow = false)
    {
        $preparedPayload = [];

        try {
            $mailing = $this->mailings->findOrFail($id);
            $preparedPayload = $this->normaliseDate($payload, allowFallback: false);

            $mailing->fill($preparedPayload);
            $mailing->save();

            $latest = $mailing->fresh();

            if ($sendNow) {
                $this->sendMail($latest->toArray());
            }

            return response()->json([
                'data' => $latest,
                'code' => 200,
                'message' => 'Mailing updated successfully',
            ]);
        } catch (\Throwable $exception) {
            Log::error('mailings.update_failed', [
                'id' => $id,
                'error' => $exception->getMessage(),
                'payload' => Arr::except($preparedPayload, ['message']),
            ]);

            return response()->json([
                'message' => 'Failed to update mailing',
                'code' => 500,
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function deleteMailing(int|string $id)
    {
        try {
            $mailing = $this->mailings->findOrFail($id);
            $mailing->delete();

            return response()->json([
                'message' => 'Mailing deleted successfully',
                'code' => 200,
            ]);
        } catch (\Throwable $exception) {
            Log::error('mailings.delete_failed', [
                'id' => $id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to delete mailing',
                'code' => 500,
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    protected function normaliseDate(array $payload, bool $allowFallback = true): array
    {
        if (array_key_exists('date', $payload) && !empty($payload['date'])) {
            $payload['date'] = Carbon::parse($payload['date'])->toDateTimeString();
        } elseif ($allowFallback) {
            $payload['date'] = Carbon::now()->toDateTimeString();
        }

        return $payload;
    }

    protected function sendMail(array $payload): void
    {
        $recipients = $this->resolveRecipients($payload['to'] ?? '');

        if (empty($recipients)) {
            throw new \InvalidArgumentException('No valid recipient found for the mailing.');
        }

        $mailable = new MailingMessage($payload);

        if (!empty($payload['from'])) {
            $senderName = $payload['title'] ?? null;
            $mailable->from($payload['from'], $senderName);
        }

        Mail::to($recipients)->send($mailable);
    }

    protected function resolveRecipients(string|array|null $recipients): array
    {
        if (is_array($recipients)) {
            return array_values(array_filter(array_map('trim', $recipients)));
        }

        if (empty($recipients)) {
            return [];
        }

        $parts = preg_split('/[;,]+/', $recipients) ?: [];

        return array_values(array_filter(array_map('trim', $parts)));
    }
}
