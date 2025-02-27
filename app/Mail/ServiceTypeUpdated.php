<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceTypeUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $company;
    public $added;
    public $removed;
    public $updated;
    public $status;
    public function __construct($company, $added, $removed, $updated, $status)
    {
        $this->company = $company;
        $this->added = $added;
        $this->removed = $removed;
        $this->updated = $updated;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Penilaian SMK-TD',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $setting = Setting::where('name', 'aplikasi')->first();
        $nama_instansi = $setting['value']['nama_instansi'];
        $alamat =  $setting['value']['alamat'];
        $nama_aplikasi = $setting['value']['nama'];
        return new Content(
            view: 'email.notification.assessment-information',
            with: [
                'company' => $this->company,
                'added' => $this->added,
                'removed' => $this->removed,
                'updated' => $this->updated,
                'status' => $this->status,
                'logoApp' => $setting ? $setting->value['logo_aplikasi'] : env('url').'/assets/images/logoapp.png',
                'nama_instansi' => $nama_instansi,
                'alamat' => $alamat,
                'nama_aplikasi' => $nama_aplikasi

            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
