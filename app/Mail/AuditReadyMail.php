<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the lead when their audit finishes, delivering the public
 * report link + a top-line summary of the scores + issue counts so
 * the email itself is useful even before they click through.
 *
 * Fired from AuditLeadController::receiveCallback() after Trakd POSTs
 * the completion payload. Skipped if the payload doesn't include a
 * lead_email (an audit started internally on the Trakd side wouldn't).
 */
class AuditReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $domain,
        public readonly string $publicUrl,
        public readonly ?string $leadName = null,
        public readonly ?int $overallScore = null,
        public readonly ?int $criticalIssues = null,
        public readonly ?int $totalIssues = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your website audit for {$this->domain} is ready",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.audit-ready');
    }
}
