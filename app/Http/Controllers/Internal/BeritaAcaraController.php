<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Jobs\NotificationUser;
use App\Models\AssessmentInterview;
use App\Models\CertificateRequest;
use App\Models\DecreeNumber;
use App\Models\InterviewAssessor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BeritaAcaraController extends Controller
{
    public function generateNumberOfLetter()
    {
        $getTemplateNumberOfLetter = DecreeNumber::select()
            ->where('is_active', 1)
            ->first();

        if (!$getTemplateNumberOfLetter) {
            return null; // Return null if no decree number template found
        }

        $currentYear = Carbon::parse()->translatedFormat('Y');
        $currentMonth = Carbon::parse()->translatedFormat('m');
        $numberToRoman = $this->numberToRomanRepresentation($currentMonth);

        $search = [
            '{{Tahun}}',
            '{{Bulan_Romawi}}',
        ];

        $replace = [
            $currentYear,
            $numberToRoman,
        ];

        $templateNumberOfLetter = $getTemplateNumberOfLetter->decree_number;
        $formatingDecreeNumber = str_replace($search, $replace, $templateNumberOfLetter);

        $letterOfCheck = substr($formatingDecreeNumber, 14);

        $checkLatestSK = AssessmentInterview::select()
            ->whereRaw('LOWER(number_of_letter) LIKE ?', ['%' . strtolower(trim($formatingDecreeNumber)) . '%'])
            ->orderBy('created_at', 'desc')
            ->first();

        $startNumber = '001';

        if ($checkLatestSK) {
            $latestNumber = substr($checkLatestSK->number_of_letter, 4, 3);
            $latestNumber = (int) $latestNumber + 1;
            $startNumber = str_pad($latestNumber, 3, '0', STR_PAD_LEFT);
        }

        $decreeNumber = str_replace('{{Nomor}}', $startNumber, $formatingDecreeNumber);

        return $decreeNumber;
    }

    public function showRecordOfVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:certificate_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $file = AssessmentInterview::where("certificate_request_id", $request->id)->first();

        // Dekode JSON string menjadi array
        $photosOfEvent = json_decode($file->photos_of_event, true) ?? [];
        $photosOfAttendanceList = json_decode($file->photos_of_attendance_list, true) ?? [];

        $data = [
            "photos_of_event" => $photosOfEvent,
            "photos_of_attendance_list" => $photosOfAttendanceList,
        ];

        return response()->json([
            'error' => false,
            'message' => "Data berhasil ditemukan",
            'data' => $data,
            'status_code' => HttpStatusCodes::HTTP_OK,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photos_of_event' => 'required',
            'photos_of_attendance_list' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $generatedNumber = $this->generateNumberOfLetter();

        if (is_null($generatedNumber)) {
            return response()->json([
                'error' => true,
                'message' => "Tidak ada nomor SK aktif, Silahkan hubungi Administrator!",
            ]);
        }

        $request['interview_status'] = 'completed';
        $request['request_status'] = 'completed_interview';
        $request['number_of_letter'] = $generatedNumber;
        $newAssessmentInterview = $this->updateAssessmentInterviewAndRequestStatus($request->id, $request);

        if ($newAssessmentInterview) {
            return response()->json([
                'error' => false,
                'message' => "Data berhasil dibuat",
                'data' => $newAssessmentInterview,
                'status_code' => HttpStatusCodes::HTTP_OK,
            ], HttpStatusCodes::HTTP_OK);
        }
    }


    public function numberToRomanRepresentation($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public function updateAssessmentInterviewAndRequestStatus($certificateRequestID, $request)
    {
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

            if (
                $oldSchedule->diffInDays($newSchedule) != 0 ||
                $oldInterview->interview_type != $newInterview->interview_type
            ) {
                $otherInformation['send_to_company'] = true;
            }

            if ($oldInterview->head_assessor !== $newInterview->head_assessor) {
                $employee = ['id' => $newInterview->head_assessor->id];
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
        return [
            'assessment_interview' => $newInterview->refresh(),
            'certiticate_request' => $newRequestStatus
        ];
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
            $assessmentInterview->photos_of_event = explode(",", $request->photos_of_event);
        }
        if ($request->photos_of_attendance_list) {
            $assessmentInterview->photos_of_attendance_list = explode(",", $request->photos_of_attendance_list);
        }

        $assessmentInterview->save();

        return $assessmentInterview;
    }

    public function changeRequestStatus($id, $status)
    {
        $oldData = $this->getCertificateRequestByID($id);
        $oldData->status = $status;
        $oldData->save();

        return $oldData;
    }

    public function deleteInterviewAssessorByAssessmentInterviewID($assessmentInterviewID)
    {
        $oldData = InterviewAssessor::where('assessment_interview_id', $assessmentInterviewID)
            ->delete();

        return $oldData;
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
    public function getCertificateRequestByID($id)
    {
        $data = CertificateRequest::select()
            ->where('id', $id)
            ->firstOrFail();

        return $data;
    }
}
