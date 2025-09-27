<?php

namespace App\Http\Controllers;

use App\Services\MailingService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MailingsController extends Controller
{
    protected MailingService $mailingService;

    public function __construct(MailingService $mailingService)
    {
        $this->mailingService = $mailingService;
    }

    public function index()
    {
        return $this->mailingService->listOfMailings();
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);
        $sendNow = $this->extractSendNow($validated, default: true);

        return $this->mailingService->createMailing($validated, $sendNow);
    }

    public function show(string $id)
    {
        return $this->mailingService->showMailing($id);
    }

    public function update(Request $request, string $id)
    {
        $validated = $this->validatePayload($request, isUpdate: true);
        $sendNow = $this->extractSendNow($validated, default: false);

        return $this->mailingService->updateMailing($id, $validated, $sendNow);
    }

    public function destroy(string $id)
    {
        return $this->mailingService->deleteMailing($id);
    }

    protected function validatePayload(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'from' => [$isUpdate ? 'sometimes' : 'required', 'email'],
            'to' => [$isUpdate ? 'sometimes' : 'required', 'email'],
            'subject' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'message' => [$isUpdate ? 'sometimes' : 'required', 'string'],
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'date' => ['sometimes', 'nullable', 'date'],
            'send_now' => ['sometimes', 'boolean'],
        ];

        $validated = $request->validate($rules);

        if (isset($validated['subject'])) {
            $validated['subject'] = trim($validated['subject']);
        }

        if (isset($validated['title'])) {
            $validated['title'] = trim((string) $validated['title']);
        }

        if (isset($validated['from'])) {
            $validated['from'] = strtolower(trim($validated['from']));
        }

        if (isset($validated['to'])) {
            $validated['to'] = strtolower(trim($validated['to']));
        }

        return $validated;
    }

    protected function extractSendNow(array &$validated, bool $default): bool
    {
        $sendNow = (bool) Arr::pull($validated, 'send_now', $default);

        return $sendNow;
    }
}
