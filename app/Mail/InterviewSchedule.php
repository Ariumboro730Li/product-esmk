<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewSchedule extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $schedule;
    public $location;
    public $role;
    public $type;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $schedule, $location,$type)
    {
        $this->name = $name;
        $this->schedule = $schedule;
        $this->location = $location;
        $this->type = $type;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informasi Jadwal Wawancara Penilaian SMK-TD',
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
            view: 'email.notification.interview-schedule',
            with: [
                'name' => $this->name,
                'schedule' => $this->schedule,
                'location' => $this->location,
                'type' => $this->type,
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
