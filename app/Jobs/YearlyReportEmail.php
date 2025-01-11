<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailQueueYearlyReport;
use App\Services\Backoffice\YearlyReportService;

class YearlyReportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($status=true)
    {
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = new YearlyReportService();
        $data = $data->getCompanyForYearlyReminder();
        if ($data) {
            foreach ($data as $key => $company) {
                $mailTo = $company->email;
                $publishDate = date('d-m-Y', strtotime($company->publish_date));
                $newPublishDate = date('d-m-Y', strtotime('+11 months', strtotime($publishDate)));
                if ($newPublishDate == date('d-m-Y')) {
                    Mail::to($mailTo)->send(new SendEmailQueueYearlyReport($company));
                }
            }
        }
        if ($this->status=='test') {
            Mail::to('test-yearly-reminder@esmk.hubdat.go.id')->send(new SendEmailQueueYearlyReport($data[0]));
        }
    }
}
