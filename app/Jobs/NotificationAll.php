<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class NotificationAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type        = Arr::get($this->data, 'type', 'success');
        $title       = Arr::get($this->data, 'title');
        $description = Arr::get($this->data, 'description');
        $data        = Arr::get($this->data, 'data');
        $users       = User::with(["roles" => fn ($q) => $q->where('roles.name', 'Assessor')->orWhere('roles.name', 'Ketua Tim')])->get();

        foreach ($users as $user) {
            if ($user->roles->count() > 0) {
                $topic = 'notification-employee-'.$user->id;

                $notifPerusahaan              = new Notification();
                $notifPerusahaan->topic       = $topic;
                $notifPerusahaan->user_id     = $user->id;
                $notifPerusahaan->type        = $type;
                $notifPerusahaan->title       = $title;
                $notifPerusahaan->description = $description;
                $notifPerusahaan->data        = json_encode($data);
                $notifPerusahaan->delivery_at = Carbon::now();
                $notifPerusahaan->save();
                // HelperAppNotificationClient($topic, HelperAppNotification($topic));
            }
        }
    }
}
