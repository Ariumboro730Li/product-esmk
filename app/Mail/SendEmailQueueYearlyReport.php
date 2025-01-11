<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailQueueYearlyReport extends Mailable
{
    use Queueable, SerializesModels;
    protected $company;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'E-mail Pengingat Laporan Tahunan',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $publishDate = date('d-m-Y', strtotime($this->company->publish_date));
        $newPublishDate = date('d-m-Y', strtotime('-11 months', strtotime($publishDate)));
        return new Content(
            view: 'email.yearly-report.index',
            with: [
                'data' => $this->company,
                'publishDate' => $newPublishDate,
                'urlESMK' => 'https://hubdat-dev2.dephub.go.id/panduan'
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
