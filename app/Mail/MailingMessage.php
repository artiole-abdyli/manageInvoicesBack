<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailingMessage extends Mailable
{
    use Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function build(): self
    {
        return $this
            ->subject($this->payload['subject'] ?? 'Message')
            ->view('emails.mailings.plain')
            ->with([
                'title' => $this->payload['title'] ?? null,
                'messageBody' => $this->payload['message'] ?? '',
                'sentDate' => $this->payload['date'] ?? now()->toDateTimeString(),
                'fromAddress' => $this->payload['from'] ?? null,
                'subject' => $this->payload['subject'] ?? null,
            ]);
    }
}
