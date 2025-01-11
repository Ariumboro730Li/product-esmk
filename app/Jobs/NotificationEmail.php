<?php

namespace App\Jobs;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class NotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;
    protected $data_req;
    protected $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail, $data_req, $topic)
    {
        $this->mail     = $mail;
        $this->data_req = $data_req;
        $this->topic    = $topic;
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function handle()
    {
        $mailTo             = $this->mail;
        $name_of_company    = isset($this->data_req['name']) ? $this->data_req['name'] : '-';

        $notif              = new Notification();
        $notif->topic       = $this->topic;
        $notif->type        = 'success';
        $notif->title       = 'Register Company';
        $notif->description = 'Pendaftaran berhasil';
        $notif->data        = json_encode([]);
        $notif->delivery_at = Carbon::now();
        $notif->save();

        Mail::send('email.notification.register', $this->data_req, function($message) use($mailTo, $name_of_company) {
            $message->to($mailTo);
            $message->subject('Pendaftaran Perusahaan '.$name_of_company.'.');
        });

        HelperAppNotificationClient($this->topic, HelperAppNotification($this->topic));
    }
}
