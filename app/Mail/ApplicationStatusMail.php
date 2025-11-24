<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function envelope(): Envelope
    {
        // Subject dinamis: "Lamaran Anda Diterima" atau "Lamaran Anda Ditolak"
        $status = $this->application->status == 'Accepted' ? 'Diterima' : 'Ditolak';
        return new Envelope(
            subject: 'Update Status Lamaran: ' . $status,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.application_status');
    }
}