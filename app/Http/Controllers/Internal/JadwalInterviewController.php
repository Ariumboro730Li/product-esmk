<?php

namespace App\Http\Controllers\Internal;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\NotificationUser;
use App\Models\InterviewAssessor;
use App\Constants\HttpStatusCodes;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\AssessmentInterview;
use App\Http\Controllers\Controller;
use App\Models\Assessor;
use Illuminate\Support\Facades\Validator;

class JadwalInterviewController extends Controller
{
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
                'description' => 'Anda dijadwalkan verifikasi lapangan pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Anda dijadwalkan verifikasi lapangan Perusahaan ' . $recipients['company']['name'] . ' pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Penjadwalan verifikasi lapangan',
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
                    'description' => 'Perubahaan verifikasi lapangan pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.',
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
                    'title' => 'Perubahan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'new_assessor_interview') {

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Anda dijadwalkan verifikasi lapangan Perusahaan ' . $recipients['company']['name'] . ' pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Penjadwalan verifikasi lapangan',
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
                $newDescription = 'Verifikasi lapangan Perusahaan ' . $recipients['company']['name'] . ' sudah selesai';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Verifikasi lapangan telah selesai',
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

    public function storeAssessmentInterviewAndUpdateRequestStatus($certificateRequestID, $request)
    {

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
                'id' => $newAssessors->assessors,
            ];

            array_push($employeeRecipients, $employee);
        }

        $newAssessor = $this->getCertificateRequestByID($certificateRequestID);

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

        return [
            'assessment_interview' => $newAssessment,
            'certiticate_request' => $requestStatus
        ];
    }

    public function storeNewAssessmentInterview($requestID, $request)
    {
        $newInterview = new AssessmentInterview();
        $newInterview->certificate_request_id = $requestID;
        $newInterview->assessor_head = $request->assessor_head;
        $newInterview->assessor_1 = $request->assessors[0] ?? null;
        $newInterview->assessor_2 = $request->assessors[1] ?? null;
        $newInterview->interview_type = $request->interview_type;
        $newInterview->schedule = $request->schedule;
        $newInterview->location = $request->location;
        $newInterview->status = $request->assessment_status;

        // Menyimpan data ke database
        $newInterview->save();

        return $newInterview;
    }



    public function storeAssessmentInterview(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'assessor_head' => 'required',
            'interview_type' => 'required',
            'schedule' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first(),
                'status' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }


        $authAppData = auth();
        $user = User::where('id', $authAppData->user()->id)->first();
        $request['assessment_status'] = 'scheduling';
        $request['request_status'] = 'scheduled_interview';
        $request['dispostion_by'] = $user->id;

        $newAssessmentInterview = $this->storeAssessmentInterviewAndUpdateRequestStatus($request->id, $request);

        return response()->json([
            'data' => $newAssessmentInterview,
            'status_code' => HttpStatusCodes::HTTP_OK
        ], HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'assessor_head' => 'required',
            'interview_type' => 'required',
            'schedule' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first(),
                'status' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $userId = $this->getModel($request);
        $request['interview_status'] = 'scheduling';
        $request['request_status'] = 'scheduled_interview';
        $request['dispostion_by'] = $userId;

        $newAssessmentInterview = $this->updateAssessmentInterviewAndRequestStatus($request);


        if ($newAssessmentInterview) {
            return response()->json([
                'error' => false,
                'data' => $newAssessmentInterview,
                'status_code' => HttpStatusCodes::HTTP_OK,
            ], HttpStatusCodes::HTTP_OK);
        }
    }
    public function updateAssessmentInterview($certificateRequestID, $request)
    {
        $assessmentInterview = $this->getLatestAssessmentInterviewByRequestID($certificateRequestID);

        if ($request->assessor_head) {
            $assessmentInterview->assessor_head = $request->assessor_head;
        }

        if (!empty($request->assessors)) {
            // Pastikan 'assessor' adalah array dan cek jumlah elemennya
            $assessmentInterview->assessor_1 = $request->assessors[0] ?? null;  // Assessor pertama
            $assessmentInterview->assessor_2 = $request->assessors[1] ?? null;  // Assessor kedua jika ada
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
            $assessmentInterview->photos_of_event = explode(",", $request->photos_of_event);
        }
        if ($request->photos_of_attendance_list) {
            $assessmentInterview->photos_of_attendance_list = explode(",", $request->photos_of_attendance_list);
        }

        $assessmentInterview->save();

        return $assessmentInterview;
    }

    public function updateAssessmentInterviewAndRequestStatus($request)
    {

        $companyRecipients = [];
        $otherInformation = ['schedule' => $request->schedule];

        $oldInterview = $this->getLatestAssessmentInterviewByRequestID($request->id);


        $newInterview = $this->updateAssessmentInterview($request->id, $request)->refresh();

        $newRequestStatus = $this->changeRequestStatus($request->id, $request->request_status);


        // Store old assessors' IDs
        $oldAssessors = $oldInterview->assessors->pluck('id')->toArray();

        $oldAssessorRecipients = [];
        $newAssessorRecipients = [];

        if ($request->interview_status === 'scheduling') {
            $otherInformation['send_to_company'] = false;

            // Delete old interview assessors
            $this->deleteInterviewAssessorByAssessmentInterviewID($newInterview->id);

            foreach ($request->assessors as $assessorId) {
                // Add new interview assessors
                $this->storeNewInterviewAssessor($newInterview->id, $assessorId, $request->assessor_head);

                $employee = ['id' => $assessorId];

                // Check if the assessor was part of the old interview
                if (in_array($assessorId, $oldAssessors)) {
                    $oldAssessorRecipients[] = $employee;
                } else {
                    $newAssessorRecipients[] = $employee;
                }
            }

            // Define old schedule and new schedule
            $oldSchedule = Carbon::parse($oldInterview->schedule);
            $newSchedule = Carbon::parse($newInterview->schedule);

            // If schedule or interview type has changed, notify the company
            if (
                $oldSchedule->diffInDays($newSchedule) != 0 ||
                $oldInterview->interview_type != $newInterview->interview_type
            ) {
                $otherInformation['send_to_company'] = true;
            }

            // If the head assessor has changed, notify the new head assessor
            if ($oldInterview->head_assessor !== $newInterview->head_assessor) {
                $newAssessorRecipients[] = ['id' => $newInterview->head_assessor];
            }

            // Prepare company recipient information
            $companyRecipients = [
                'id' => $newRequestStatus->company_id,
                'name' => $newRequestStatus->company->name,
            ];

            // Send notification for new interview assessors
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

            // Send notification for updated interview assessment
            $recipients = [
                'company' => $companyRecipients,
                'employee' => $oldAssessorRecipients
            ];

            $this->generateNotificationByStatus(
                'update_inteview_assessment',
                $recipients,
                $otherInformation
            );
        }

        // Handle completed interview status
        if ($request->request_status === 'completed_interview') {
            $companyRecipients = [
                'id' => $newRequestStatus->company_id,
                'name' => $newRequestStatus->company->name
            ];

            foreach ($newInterview->assessors as $assessor) {
                $oldAssessorRecipients[] = ['id' => $assessor->id];
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

        return [
            'assessment_interview' => $newInterview->refresh(),
            'certificate_request' => $newRequestStatus
        ];
    }
    public function deleteInterviewAssessorByAssessmentInterviewID($assessmentInterviewID)
    {
        $oldData = InterviewAssessor::where('assessment_interview_id', $assessmentInterviewID)
            ->delete();

        return $oldData;
    }

    public function changeRequestStatus($id, $status)
    {
        $oldData = $this->getCertificateRequestByID($id);
        $oldData->status = $status;
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
    public function storeNewInterviewAssessor($assessmentInterviewID, $assessor, $dispositionBy)
    {
        $newData = new InterviewAssessor();
        $newData->assessment_interview_id = $assessmentInterviewID;
        $newData->assessor = $assessor;
        $newData->disposition_by = $dispositionBy;
        $newData->save();

        return $newData;
    }
    public function getJadwalInterview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:certificate_requests,id',
        ], [
            'id.required' => 'ID Di Perlukan',
            'id.exists' => 'ID Tidak Di Temukan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $assessmentInterview = $this->getLatestAssessmentInterviewByRequestID($request->id);
        if (!$assessmentInterview) {
            return response()->json([
                'error' => true,
                'message' => "Data tidak ditemukan",
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $assessmentInterview->id,
            'assessor_head' => $assessmentInterview->assessor_head,
            'assessorHead' => $assessmentInterview->assessorHead,
            'assessors' => $assessmentInterview->assessors,
            'interview_type' => $assessmentInterview->interview_type,
            'notes' => $assessmentInterview->notes,
            'number_of_letter' => $assessmentInterview->number_of_letter,
            'photos_of_attendance_list' => $assessmentInterview->photos_of_attendance_list,
            'photos_of_event' => $assessmentInterview->photos_of_event,
            'schedule' => $assessmentInterview->schedule,
            'status' => $assessmentInterview->status,
            'created_at' => $assessmentInterview->created_at,
        ];

        return response()->json([
            'error' => false,
            'data' => $data,
            'status_code' => HttpStatusCodes::HTTP_OK,
        ], HttpStatusCodes::HTTP_OK);
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
}
