<?php

namespace App\Jobs\Esmk;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $mail;
    protected $data_req;
    /**
     * Create a new job instance.
     */
    public function __construct($mail, $data_req)
    {
        $this->mail = env('MAIL_SAMPLE_USER') ? env('MAIL_SAMPLE_USER') : $mail;
        $this->data_req = $data_req;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailTo             = $this->mail;
        $name_of_company    = isset($this->data_req['name']) ? $this->data_req['name'] : '-';

        $settings = Setting::where('name', 'aplikasi')->first();

        if($settings){
            $this->data_req['logo'] = $settings->value['logo_aplikasi'] ?? null;;
            $this->data_req['nama_instansi'] = $settings->value['nama_instansi'] ?? null;
        }

        Mail::send('email.register', $this->data_req, function($message) use($mailTo, $name_of_company) {
            $message->to($mailTo);
            $message->subject('Pendaftaran Perusahaan '.$name_of_company.'.');
        });

    }
}
