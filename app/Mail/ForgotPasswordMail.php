<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = env('MAIL_SAMPLE_USER') ? env('MAIL_SAMPLE_USER') : $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-mail Reset Kata Sandi Pengguna',
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
        return new Content(
            view: 'email.auth.forgot-password',
            with: [
                'token' => $this->token,
                'logoApp' => $setting ? $setting->value['logo_aplikasi'] : env('url').'/assets/images/logoapp.png',
                'nama_instansi' => $nama_instansi,
                'alamat' => $alamat,
                'email' => $this->email
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
