<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailQueueExpiredRequest;
use App\Services\Backoffice\CertificateRequestService;
use Carbon\Carbon;

class ExpiredRequestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($status)
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
        $certReqService = new CertificateRequestService();
        $data = $certReqService->getNotPassedAssessment();
        $addDay = 13; // start from 0

        $statusCertificateRequest = [];
        if (count($data) > 0) {
            for ($i=0; $i < count($data); $i++) { 
                $startDate = Carbon::createFromFormat("Y-m-d H:i:s", $data[$i]["updated_at"]);
                $endDate = Carbon::now();
                $totalWeekends = $startDate->diffInDaysFiltered(function (Carbon $date){
                    return !$date->isWeekday();
                }, $endDate);
                $lengthDay = $startDate->diffInDays($endDate);
                $workDay = $lengthDay - $totalWeekends;

                echo "updatedAt: ".$startDate . PHP_EOL;
                echo "endDate: ".$endDate . PHP_EOL;
                echo "totalWeekends: ".$totalWeekends . PHP_EOL;
                echo "lengthDay: ".$lengthDay . PHP_EOL;
                echo "workDay: ".$workDay . PHP_EOL;

                if ($workDay >= $addDay && $data[$i]["status"] == "not_passed_assessment") {
                    $id = $data[$i]["id"];
                    $statusCertificateRequest["status"] = "expired";
                    $udpateDataCertReq = $certReqService->updateCertificateRequest($id, $statusCertificateRequest, []);
                    $mailTo = $data[$i]["email"];
                    Mail::to($mailTo)->send(new SendEmailQueueExpiredRequest($data[$i]));
                }
            }
        }
    }
}
