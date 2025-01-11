<?php

namespace App\Services\Backoffice;

use App\Jobs\NotificationUser;
use App\Models\SmkElement;
use App\Models\CertificateRequest;
use App\Models\CertificateRequestAssessment;
use App\Models\AssessmentInterview;
use App\Models\CertificateSmk;
use App\Models\YearlyReportLog;
use App\Models\Dirjen;
use App\Models\InterviewAssessor;
use App\Models\CertificateTemplate;
use App\Models\Signer;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\FileService;

use Barryvdh\DomPDF\Facade\Pdf;
use QrCode;

use App\Models\WorkUnit;
use App\Models\WorkUnitHasService;

class CertificateRequestService
{
    public function getDatatable($request, $company_id=false)
    {
        // dd(11);
        $certificateRequest = CertificateRequest::with([
            'dispositionBy',
            'dispositionTo',
            'company'
        ])->select('certificate_requests.*', 'assessment_interviews.schedule as schedule_interview', 'companies.id as company_id', 'companies.name as company_name', DB::raw("DATE_PART('year', certificate_requests.created_at) || '00000' || certificate_requests.id AS regnumber"))
        ->leftJoin('companies', 'certificate_requests.company_id', '=', 'companies.id')

        ->leftjoin('assessment_interviews', function($join) {
            $join->on('certificate_requests.id', 'certificate_request_id')
                ->where('assessment_interviews.is_active', true);
        })->where('certificate_requests.status', '!=', 'draft');

        if ($company_id) {
            $certificateRequest = $certificateRequest->where('certificate_requests.company_id', $company_id);
        }

        if ($request->serchByPenilai != "") {
            $certificateRequest = $certificateRequest->where('certificate_requests.disposition_to', $request->serchByPenilai);
        }

        if ($request->serchByPerusahaan != "") {
            $certificateRequest = $certificateRequest->where('certificate_requests.company_id', $request->serchByPerusahaan);
        }

        if ($request->serchByStatus != "") {
            $certificateRequest = $certificateRequest->where('certificate_requests.status', $request->serchByStatus);
        }

        if ($request->date_from != "" && $request->date_to !="") {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d H:i:s');
            $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d H:i:s');
            $certificateRequest = $certificateRequest->whereBetween('certificate_requests.created_at', [$date_from, $date_to]);
        }

        if ($request['columns'][1]['search']['value']) {
            $certificateRequest = $certificateRequest
                ->where('companies.name', 'ilike', '%'. $request['columns'][1]['search']['value'] .'%')
                ->orWhere(DB::raw("DATE_PART('year', certificate_requests.created_at) || '00000' || certificate_requests.id"),  'like', '%'. $request['columns'][1]['search']['value'] .'%');
        }

        return DataTables::eloquent($certificateRequest)->toJson();
    }

    function generateRegNumber($createdAt, $data) {
        $year = Carbon::parse($createdAt)->format('Y');
        $dataYear = intval($year . '000000');
        $regNumber = $dataYear + intval($data);

        return $regNumber;
    }

    public function generateNotificationByStatus($status, $recipients, $information = [])
    {
        $currentDate = Carbon::now()->timestamp;
        $topicForCompany = 'notification-company';
        $topicForEmployee = 'notification-employee';

        $data = array();

        if ($status === 'rejected') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = array(
                'topic' => $newTopicForCompany,
                'type' => 'warning',
                'title' => 'Pengajuan ditolak',
                'description' => 'Pengajuan ditolak, silahkan cek kembali data yang dikirim!.',
                'data' => json_encode([]),
                'delivery_at' => $currentDate
            );

            array_push($data, $forCompany);

        } else if ($status === 'disposition') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Disposisi',
                'description' => 'Pengajuan sertifikat SMK sedang proses disposisi',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Anda disposisi oleh untuk melakukan penilaian {$recipients['company']['name']}";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'success',
                'title' => 'Disposisi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);
        } else if ($status === 'not_passed_assessment') {

            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'warning',
                'title' => 'Tidak lulus penilaian',
                'description' => 'Pengajuan tidak lulus penilaian dan dibutuhkan perbaikan dokumen',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);

        } else if ($status === 'passed_assessment') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Lulus penilaian',
                'description' => 'Dokumen sudah dinilai dan diteruskan untuk verifikasi penilaian.',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Dokumen {$recipients['company']['name']} lulus penilaian, dan dibutuhkan verifikasi";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'success',
                'title' => 'lulus verifikasi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);
        } else if ($status === 'not_passed_assessment_verification') {

            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'warning',
                'title' => 'Penilaian dokumen tidak lulus verifikasi',
                'description' => 'Penilaian dokumen tidak lulus verifikasi dan akan dilakukan penilaian ulang.',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Penilaian dokumen {$recipients['company']['name']} tidak lulus verifikasi dan diharuskan penilaian ulang";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'wanning',
                'title' => 'Penilaian dokumen tidak lulus verifikasi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);

        } else if ($status === 'passed_assessment_verification') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Penilaian dokumen lulus verifikasi',
                'description' => 'Penilaian dokumen lulus verifikasi dan akan dijadwalkan verifikasi lapangan.',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Penilaian dokumen {$recipients['company']['name']} lulus verifikasi";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'success',
                'title' => 'Penilaian dokumen lulus verifikasi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);

        } else if ($status === 'scheduled_interview') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Penjadwalan verifikasi lapangan',
                'description' => 'Anda dijadwalkan verifikasi lapangan pada Hari '.Carbon::parse($information['schedule'])->locale('id')->dayName.', Tanggal '.Carbon::parse($information['schedule'])->format('d F Y').'.',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Anda dijadwalkan verifikasi lapangan Perusahaan '.$recipients['company']['name'].' pada Hari '.Carbon::parse($information['schedule'])->locale('id')->dayName.', Tanggal '.Carbon::parse($information['schedule'])->format('d F Y').'.';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' =>'Penjadwalan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'update_inteview_assessment') {
            if ($information['send_to_company']) {
                $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
                $forCompany = [
                    'topic' => $newTopicForCompany,
                    'type' => 'success',
                    'title' => 'Perubahan verifikasi lapangan',
                    'description' => 'Perubahaan verifikasi lapangan pada Hari '.Carbon::parse($information['schedule'])->locale('id')->dayName.', Tanggal '.Carbon::parse($information['schedule'])->format('d F Y').'.',
                    'delivery_at' => $currentDate
                ];

                array_push($data, $forCompany);
            }

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = "Perubahaan verifikasi lapangan Perusahaan {$recipients['company']['name']}.";

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' =>'Perubahan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'new_assessor_interview') {

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Anda dijadwalkan verifikasi lapangan Perusahaan '.$recipients['company']['name'].' pada Hari '.Carbon::parse($information['schedule'])->locale('id')->dayName.', Tanggal '.Carbon::parse($information['schedule'])->format('d F Y').'.';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' =>'Penjadwalan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'completed_interview') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";

            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Verifikasi lapangan telah selesai',
                'description' => 'Verifikasi lapangan telah selesai, saat ini dokumen Anda sedang proses tahap penerbitan Berita Acara',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Verifikasi lapangan Perusahaan '.$recipients['company']['name'].' sudah selesai';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' =>'Verifikasi lapangan telah selesai',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }

        } else if ($status === 'certificate_validation') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";

            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Pengesahan Sertifikat',
                'description' => 'Selamat! Sertifikat SMK anda sudah terbit.',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);
        }

        dispatch(new NotificationUser($data))->delay(Carbon::now()->addSeconds(3));

    }

    public function getDetailByID($requestID)
    {
        $data = CertificateRequest::with([
                'company',
                'company.serviceTypes',
                'company.province',
                'company.city',
                'dispositionBy',
                'dispositionTo',
            ])
            ->join('certificate_request_assessments', function($join) {
                $join->on('certificate_requests.id', 'certificate_request_assessments.certificate_request_id')
                    ->where('certificate_request_assessments.is_active', true);
            })
            ->leftJoin('application_letters', 'certificate_requests.id', 'application_letters.certificate_request_id')
            ->select(
                'certificate_requests.*',
                'certificate_request_assessments.assessor as certificate_request_assessor',
                'element_properties',
                'answers',
                'assessments',
                'revision',
                'certificate_request_assessments.status as assessment_status',
                'certificate_request_assessments.validation_notes as validation_notes',
                'application_letters.number_of_application_letter as number_of_application_letter',
                'application_letters.date_of_letter as date_of_application_letter',
                'application_letters.file as file_of_application_letter'
            )
            ->where('certificate_requests.id', $requestID)
            ->first();

        return $data;
    }

    public function storeRequestAssessment($certificateRequestID, $request)
    {
        $newData = new CertificateRequestAssessment();
        $newData->certificate_request_id = $certificateRequestID;
        $newData->element_properties = json_encode($request['element_properties'], true);
        $newData->answers = json_encode($request['answers']);
        $newData->status = $request['status'];

        if (array_key_exists('assessor', $request)) {
            $newData->assessor = $request['assessor'];
        }

        if (array_key_exists('assessments', $request)) {
            $newData->assessments = json_encode($request['assessments']);
        }

        if (array_key_exists('validation_notes', $request)) {
            $newData->validation_notes = $request['validation_notes'];
        }

        if (array_key_exists('rejected_note', $request)) {
            $newData->rejected_note = $request['rejected_note'];
        }

        $newData->save();

        return $newData;
    }

    public function storeRequest($id, $request)
    {
        try {
            DB::beginTransaction();

            $latestCertificateAssessment = $this->getLatestAssessmentByRequestID($id);

            $certicateRequestAssessment = $this->storeRequestAssessment($id, $request);

            $changeRequestStatus = $this->changeRequestStatus($id, $request->request_status);

            DB::commit();

            return $changeRequestStatus;

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;

        }
    }

    public function updateCertificateRequest($id, $tempCertificateRequest, $tempCertificateRequestAssessment)
    {
        try {
            DB::beginTransaction();

            $recipients = [];

            $latestAssessment = $this->getLatestAssessmentByRequestID($id);

            if (!empty($tempCertificateRequestAssessment)) {
                $newAssessment = $this->storeRequestAssessment($id, $tempCertificateRequestAssessment);
                $nonActiveOldAssessment = $this->nonActiveOldAssessment($latestAssessment->id);
            }

            if ($tempCertificateRequest['status'] === 'disposition') {
                $changeRequestStatus = $this->updateAssessor($id, $tempCertificateRequest);

                $recipients = [
                    'company' => [
                        'id' => $latestAssessment->certificate_request->company_id,
                        'name' => $latestAssessment->certificate_request->company->name
                    ],
                    'employee' => [
                        'id' => $changeRequestStatus->disposition_to,
                        'name' => $changeRequestStatus->dispositionTo->name
                    ]
                ];

            } else {
                $changeRequestStatus = $this->changeRequestStatus($id, $tempCertificateRequest['status']);

                $recipientEmployee = [];

                if ($tempCertificateRequest['status'] == 'passed_assessment') {
                    $recipientEmployee['id'] = $changeRequestStatus->disposition_by;
                    $recipientEmployee['name'] = $changeRequestStatus->dispositionBy->name;
                }

                if ($tempCertificateRequest['status'] == 'not_passed_assessment_verification') {
                    $recipientEmployee['id'] = $changeRequestStatus->disposition_to;
                    $recipientEmployee['name'] = $changeRequestStatus->dispositionBy->name;
                }

                if ($tempCertificateRequest['status'] == 'passed_assessment_verification') {
                    $recipientEmployee['id'] = $changeRequestStatus->disposition_to;
                    $recipientEmployee['name'] = $changeRequestStatus->dispositionBy->name;
                }

                if ($tempCertificateRequest['status'] == 'expired') {
                    $recipientEmployee['id'] = $changeRequestStatus->disposition_to;
                    $recipientEmployee['name'] = $changeRequestStatus->dispositionBy->name;
                }


                $recipients = [
                    'company' => [
                        'id' => $latestAssessment->certificate_request->company_id,
                        'name' => $latestAssessment->certificate_request->company->name
                    ],
                    'employee' => $recipientEmployee
                ];
            }

            $this->generateNotificationByStatus($tempCertificateRequest['status'], $recipients);

            DB::commit();

            return true;

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;

        }
    }

    public function getAssessmentByID($id)
    {
        $data = CertificateRequestAssessment::select()
            ->where('id', $id)
            ->firstOrFail();

        return $data;
    }

    public function getLatestAssessmentByRequestID($id)
    {
        $data = CertificateRequestAssessment::select()
            ->where('certificate_request_id', $id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->firstOrFail();

        return $data;
    }

    public function nonActiveOldAssessment($assessmentID)
    {
        $oldData = $this->getAssessmentByID($assessmentID);
        $oldData->is_active = false;
        $oldData->save();

        return $oldData;
    }

    public function getCertificateRequestByID($id)
    {
        $data = CertificateRequest::select()
            ->where('id', $id)
            ->firstOrFail();

        return $data;
    }

    public function changeRequestStatus($id, $status)
    {
        $oldData = $this->getCertificateRequestByID($id);
        $oldData->status = $status;
        $oldData->save();

        return $oldData;
    }

    public function getAssessmentHistoryByRequestID($id)
    {
        $data = CertificateRequestAssessment::select('id', 'status', 'created_at')
            ->where('certificate_request_id', $id)
            ->where('status', '!=', 'draft')
            ->orderBy('created_at', 'asc')
            ->get();

        return $data;
    }

    public function updateAssessor($id, $request)
    {
        $newAssessor = $this->getCertificateRequestByID($id);

        $newAssessor->disposition_by = $request['disposition_by'];
        $newAssessor->disposition_to = $request['disposition_to'];

        if ($request['status']) {
            $newAssessor->status = $request['status'];
        }

        $newAssessor->save();

        return $newAssessor;

    }

    public function storeNewAssessmentInterview($requestID, $request)
    {
        $newInterview = new AssessmentInterview();
        $newInterview->certificate_request_id = $requestID;
        $newInterview->assessor_head = $request->assessor_head;
        $newInterview->assessor_1 = $request->assessor_1;
        $newInterview->assessor_2 = $request->assessor_2;
        $newInterview->interview_type = $request->interview_type;
        $newInterview->schedule = $request->schedule;
        $newInterview->location = $request->location;
        $newInterview->status = $request->assessment_status;

        $newInterview->save();

        return $newInterview;
    }

    public function storeAssessmentInterviewAndUpdateRequestStatus($certificateRequestID, $request)
    {
        try {
            DB::beginTransaction();

            $newAssessment = $this->storeNewAssessmentInterview($certificateRequestID, $request);

            $requestStatus = $this->changeRequestStatus($certificateRequestID, $request->request_status);

            // list employee for send notification
            $employeeRecipients = [];

            for ($i = 0; $i < count($request->assessors); $i++) {
                $newAssessors = $this->storeNewInterviewAssessor(
                    $newAssessment->id,
                    $request->assessors[$i],
                    $request->dispostion_by
                );

                $employee = [
                    'id' => $newAssessors->assessor,
                ];

                array_push($employeeRecipients, $employee);
            }

            // $newAssessor = $this->getCertificateRequestByID($certificateRequestID);

            if (!empty($request['assessor_head'])) {
                $employee = [
                    'id' => $newAssessment->assessorHead->id,
                    'name' => $newAssessment->assessorHead->name
                ];

                array_push($employeeRecipients, $employee);
            }

            $recipients = [
                'company' => [
                    'id' => $requestStatus->company_id,
                    'name' => $requestStatus->company->name
                ],
                'employee' => $employeeRecipients
            ];

            $information = [
                'schedule' => $request->schedule
            ];

            $this->generateNotificationByStatus(
                $request->request_status,
                $recipients,
                $information
            );

            DB::commit();

            return [
                'assessment_interview' => $newAssessment,
                'certiticate_request' => $requestStatus
            ];

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;

        }
    }

    public function storeNewInterviewAssessor($assessmentInterviewID, $assessor, $dispositionBy)
    {
        $newData = new InterviewAssessor();
        $newData->assessment_interview_id = $assessmentInterviewID;
        $newData->assessor = $assessor;
        $newData->disposition_by = $dispositionBy;
        $newData->save();

        return $newData;
    }

    public function getInterviewAssessorByAssessmentInterviewID($assessmentInterviewID)
    {
        $data = InterviewAssessor::where('assessment_interview_id', $assessmentInterviewID)
        ->pluck('id')
        ->toArray();

        return $data;
    }

    public function deleteInterviewAssessorByAssessmentInterviewID($assessmentInterviewID)
    {
        $oldData = InterviewAssessor::where('assessment_interview_id', $assessmentInterviewID)
        ->delete();

        return $oldData;
    }

    public function getLatestAssessmentInterviewByRequestID($certificateRequestID)
    {
        $data = AssessmentInterview::with([
            'assessorHead',
            'assessors'
        ])
            ->select('*')
            ->where('certificate_request_id', $certificateRequestID)
            ->where('is_active', '=', true)
            ->first();
        return $data;
    }

    public function updateAssessmentInterview($certificateRequestID, $request)
    {
        $assessmentInterview = $this->getLatestAssessmentInterviewByRequestID($certificateRequestID);

        if ($request->assessor_head) {
            $assessmentInterview->assessor_head = $request->assessor_head;
        }
        if ($request->interview_type) {
            $assessmentInterview->interview_type = $request->interview_type;
        }
        if ($request->schedule) {
            $assessmentInterview->schedule = $request->schedule;
        }
        if ($request->note) {
            $assessmentInterview->notes = $request->note;
        }
        if ($request->number_of_letter) {
            $assessmentInterview->number_of_letter = $request->number_of_letter;
        }
        if ($request->interview_status) {
            $assessmentInterview->status = $request->interview_status;
        }
        if ($request->photos_of_event) {
            $assessmentInterview->photos_of_event = explode (",", $request->photos_of_event);
        }
        if ($request->photos_of_attendance_list) {
            $assessmentInterview->photos_of_attendance_list = explode (",", $request->photos_of_attendance_list);
        }

        $assessmentInterview->save();

        return $assessmentInterview;

    }

    public function updateAssessmentInterviewAndRequestStatus($certificateRequestID, $request)
    {
        try {
            DB::beginTransaction();
            // temp employee recipients

            $companyRecipients = [];
            $otherInformation = [
                'schedule' => $request->schedule
            ];

            $oldInterview = $this->getLatestAssessmentInterviewByRequestID($certificateRequestID);
            $newInterview = $this->updateAssessmentInterview($certificateRequestID, $request)->refresh();

            $newRequestStatus = $this->changeRequestStatus($certificateRequestID, $request->request_status);

            $oldAssessors = [];
            for ($i = 0; $i < count($oldInterview->assessors); $i++) {
                array_push($oldAssessors, $oldInterview->assessors[$i]->id);
            }

            $oldAssessorRecipients = [];
            $newAssessorRecipients = [];

            if ($request->interview_status === 'scheduling') {

                $otherInformation['send_to_company'] = false;
                // for old interview assessors
                $oldInterviewAssessors = $this->deleteInterviewAssessorByAssessmentInterviewID($newInterview->id);
                for ($i = 0; $i < count($request->assessors); $i++) {
                    // add interview assessors
                    $newInterviewAssessors = $this->storeNewInterviewAssessor(
                        $newInterview->id,
                        $request->assessors[$i],
                        $request->dispostion_by
                    );

                    $employee = ['id' => $request->assessors[$i]];

                    if (in_array($request->assessors[$i], $oldInterview->assessors->pluck('id')->toArray())) {
                        array_push($oldAssessorRecipients, $employee);
                    } else {
                        array_push($newAssessorRecipients, $employee);
                    }
                }

                // define old schedule and new schedule
                $oldSchedule = Carbon::parse($oldInterview->schedule);
                $newSchedule = Carbon::parse($newInterview->schedule);

                if ($oldSchedule->diffInDays($newSchedule) != 0 ||
                    $oldInterview->interview_type != $newInterview->interview_type
                ) {
                    $otherInformation['send_to_company'] = true;
                }

                $newAssessment = null;
                if ($oldInterview->head_assessor !== $newInterview->head_assessor) {
                    $employee = ['id' => $newAssessment->head_assessor->id];
                    array_push($newAssessorRecipients, $employee);
                }

                $companyRecipients = [
                    'id' => $newRequestStatus->company_id,
                    'name' => $newRequestStatus->company->name,
                ];

                // send notification for new interview assessors
                if (count($newAssessorRecipients) > 0) {
                    $newRecipients = [
                        'employee' => $newAssessorRecipients,
                        'company' => $companyRecipients
                    ];

                    $this->generateNotificationByStatus(
                        'new_assessor_interview',
                        $newRecipients,
                        $otherInformation
                    );
                }

                $recipients = [
                    'company' => $companyRecipients,
                    'employee' => $oldAssessorRecipients
                ];

                // send notification for new employee
                $this->generateNotificationByStatus(
                    'update_inteview_assessment',
                    $recipients,
                    $otherInformation
                );

            }

            if ($request->request_status === 'completed_interview') {
                $companyRecipients = [
                    'id' => $newRequestStatus->company_id,
                    'name' => $newRequestStatus->company->name
                ];

                for ($i = 0; $i < count($newInterview->assessors); $i++) {
                    $employee = ['id' => $newInterview->assessors[$i]->id];
                    array_push($oldAssessorRecipients, $employee);
                }

                $recipients = [
                    'company' => $companyRecipients,
                    'employee' => $oldAssessorRecipients
                ];

                $this->generateNotificationByStatus(
                    $request->request_status,
                    $recipients
                );
            }

            DB::commit();

            return [
                'assessment_interview' => $newInterview->refresh(),
                'certiticate_request' => $newRequestStatus
            ];

        } catch (\Exception $e) {

            DB::rollback();

            throw $e;

        }
    }

    public function storeCertificate($companyID, $certificateRequestID, $request, $certificateDigital)
    {
        $newCertificate = new CertificateSmk();
        $newCertificate->number_of_certificate   = $request->number_of_certificate;
        $newCertificate->publish_date            = $request->publish_date;
        $newCertificate->certificate_file        = $request->certificate_file;
        $newCertificate->sk_file                 = $request->sk_file;
        $newCertificate->rov_file                = $request->rov_file;
        $newCertificate->certificate_request_id  = $certificateRequestID;
        $newCertificate->company_id              = $companyID;
        $newCertificate->is_active               = true;
        $newCertificate->sign_by                 = $request->sign_by;
        $newCertificate->certificate_digital_url = $certificateDigital;

        if($request->expired_date) {
            $newCertificate->expired_date = $request->expired_date;
        }

        $newCertificate->save();

        return $newCertificate;
    }

    public function storeYearlyReportLog($companyID, $request)
    {
        $newData = new YearlyReportLog();
        $newData->company_id = $companyID;
        $newData->year = $request->year;
        $newData->due_date = $request->due_date;
        $newData->save();
    }

    public function certificateRelease($certificateRequestID, $request)
    {
        try {
            DB::beginTransaction();

            $signer = $this->getSignerByID($request->sign_by);

            //change request status
            $requestStatus = $this->changeRequestStatus($certificateRequestID, $request->request_status);
            //generate Certificate Digital
            $certificateDigital = $this->generateCertificate($request, $requestStatus->company, $signer);
            // store all certificate data
            $certificate = $this->storeCertificate($requestStatus->company_id, $certificateRequestID, $request, $certificateDigital);
            // store yearly report log
            $yearlyReportLog = $this->storeYearlyReportLog( $requestStatus->company_id, $request);

            $recipients = [
                'company' => [
                    'id' => $requestStatus->company_id,
                    'name' => $requestStatus->company->name
                ],
            ];

            $this->generateNotificationByStatus(
                $request->request_status,
                $recipients
            );

            DB::commit();

            return $certificate;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateAssessmentStatus($userID, $assessmentID, $status)
    {
        $oldData = $this->getAssessmentByID($assessmentID);
        $oldData->status = 'rejected';
        $oldData->assessor = $userID;
        $oldData->save();

        return $oldData;
    }

public function getDirjenTTD($id)
{
    $dirjenTTD = Dirjen::select()
    ->with([
        'user'
        ])
        ->where('is_active', '1')
        ->where('user_id', $id)
        ->first();

    return $dirjenTTD;
}

    public function getCertificateTemplate()
    {
        $template = CertificateTemplate::select()
        ->first();

        return $template;
    }

    public function generateCertificate($request, $company, $signer)
    {
        $templateCertificate = $this->getCertificateTemplate();
        $templateHtml = $templateCertificate->content;

        $certificateNumber = $request->number_of_certificate;
        $certificateNumberSpan = "<span>{$certificateNumber}</span>";
        $qrCode = QrCode::size(75)->generate($certificateNumber);
        $svgQrCode = base64_encode(explode("\n", $qrCode)[1]);
        $search = [
            '{{certificate_number}}',
            '{{company_name}}',
            '{{company_address}}',
            '{{wu_city}}',
            '{{release_date}}',
            '{{signer_position}}',
            '{{signer_name}}',
            '{{signer_identity_type}}',
            '{{signer_identity_number}}',
            '{{qrCode}}'
        ];

        Carbon::setLocale('id');
        $publishDate = Carbon::parse($request->publish_date)->locale('id');
        $publishDate->settings(['formatFunction' => 'translatedFormat']);
        $publishDateInIndonesia = $publishDate->format('j F Y');

        $svgQrCode = '<img src="data:image/svg+xml;base64,'.$svgQrCode.'" />';

        $replace = [
            $certificateNumberSpan,
            $company->name,
            $company->address,
            $this->workUnitDetail->city->name,
            $publishDateInIndonesia,
            $signer->position,
            $signer->name,
            $signer->identity_type,
            $signer->identity_number,
            $svgQrCode
        ];

        $templateHtml = str_replace($search, $replace, $templateHtml);

        $dompdf = Pdf::loadHtml($templateHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = base64_encode($dompdf->output());
        $filename = "sertifikat-{$company->name}-{$request->number_of_certificate}.pdf";

        $uploadService  = new FileService();
        $uploadCertificate = $uploadService->uploadFileDompfd($pdfContent, $filename);

        return $uploadCertificate;
    }

    public function getSigners($isWorkUnitOnly = false)
    {
        $data = Signer::select();
        $data = $data->get();

        return $data;
    }


    public function getSignerByID($id)
    {
        $data = Signer::select()
        ->findOrfail($id);

        return $data;
    }

    public function getNotPassedAssessment($status='not_passed_assessment')
    {
        $data = CertificateRequest::select('companies.name', 'companies.email',
            'companies.username', 'companies.nib', 'companies.address', 'companies.pic_name',
            'certificate_requests.id', 'certificate_requests.status', 'certificate_requests.created_at', 'certificate_requests.updated_at'
        )
        ->join('companies','certificate_requests.company_id','companies.id')
        ->where('certificate_requests.status', $status)
        ->orderBy('created_at', 'asc')
        ->get();

        return $data;
    }
}
