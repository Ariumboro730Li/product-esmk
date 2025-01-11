<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Jobs\NotificationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\CertificateRequestAssessment;
use App\Models\CompanyServiceType;
use App\Models\ServiceType;
use App\Models\User;

class PengajuanSMKPerusahaanController extends Controller
{
    private $coverageService;

    public function __construct() {}
    public function serviceType(Request $request)
    {
        $query = ServiceType::select('id', 'name',);

        // Jika ada parameter 'search', lakukan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower(trim($request->search));

            // Tambahkan kondisi pencarian pada query
            $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
        }

        // Eksekusi query dan ambil hasilnya
        $service = $query->get();
        // dd($service);
        if (!$service) {

            return response()->json([
                'errors' => true,
                'message' => 'Data Tidak Di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $service,
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function index(Request $request)
    {
        $meta = [
            'orderBy' => $request->ascending ? 'asc' : 'desc',
            'limit' => $request->limit,
        ];

        // Build the query
        $certificateRequest = CertificateRequest::with(['dispositionBy', 'dispositionTo', 'company', 'company.serviceTypes'])
            ->select(
                'certificate_requests.*',
                'assessment_interviews.schedule as schedule_interview',
                'companies.id as company_id',
                'companies.name as company_name',
                DB::raw("CONCAT(YEAR(certificate_requests.created_at), '00000', certificate_requests.id) AS regnumber")
            )
            ->leftJoin('companies', 'certificate_requests.company_id', '=', 'companies.id')
            ->leftJoin('assessment_interviews', function ($join) {
                $join->on('certificate_requests.id', '=', 'assessment_interviews.certificate_request_id')
                    ->where('assessment_interviews.is_active', true);
            })
            ->where('certificate_requests.status', '!=', 'draft');


        // Apply filters from the request
        if ($request->company_id) {
            $certificateRequest->where('certificate_requests.company_id', $request->company_id);
        }


        if (!empty($request->searchByPenilai)) {
            $certificateRequest->where('certificate_requests.disposition_to', $request->searchByPenilai);
        }

        if (!empty($request->searchByPerusahaan)) {
            $certificateRequest->where('certificate_requests.company_id', $request->searchByPerusahaan);
        }

        if (!empty($request->searchByStatus)) {
            $certificateRequest->where('certificate_requests.status', $request->searchByStatus);
        }

        // Date filter
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = Carbon::createFromFormat('Y-m-d', $request->date_from)->startOfDay();
            $date_to = Carbon::createFromFormat('Y-m-d', $request->date_to)->endOfDay();
            $certificateRequest->whereBetween('certificate_requests.created_at', [$date_from, $date_to]);
        }

        // Filter by search value in columns, including regnumber
        if ($request->search !== null) {
            $search = strtolower(trim($request->search));

            // Search across company name, city name, service types, and regnumber
            $certificateRequest->where(function ($query) use ($search) {
                // Search in regnumber
                $query->whereRaw("LOWER(CONCAT(YEAR(certificate_requests.created_at), '00000', certificate_requests.id)) LIKE ?", ["%$search%"])
                    // Search in company name
                    ->orWhereHas('company', function ($query) use ($search) {
                        $query->whereRaw("LOWER(companies.name) LIKE ?", ["%$search%"]);
                    });
            });
        }

        // Order and paginate the query
        $data = $certificateRequest->orderBy('certificate_requests.created_at', $meta['orderBy'])->paginate($meta['limit']);

        // Return response
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $data->toArray()['data'],
            'pagination'    => [
                'total'        => $data->total(),
                'count'        => $data->count(),
                'per_page'     => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages'  => $data->lastPage()
            ]
        ], HttpStatusCodes::HTTP_OK);
    }

    public function detail(Request $request)
    {
        // Validate request
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

        // Retrieve the certificate request details
        $certificateRequest = $this->getDetailByID($request->id);

        if (!$certificateRequest) {
            return response()->json([
                'error' => true,
                'message' => 'Data tidak ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
        // Prepare response data
        $data = $certificateRequest;
        $data['answers'] = json_decode($certificateRequest->answers);
        $data['element_properties'] = json_decode($certificateRequest->element_properties);
        $data['assessments'] = json_decode($certificateRequest->assessments);

        return response()->json([
            'error' => false,
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $request)
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

        $userId = $this->getModel($request);
        $tempCertificateRequest = [];
        $tempCertificateRequestAssessment = [];


        if ($request->has('assessor_head')) {
            $tempCertificateRequest['disposition_by'] = $request->assessor_head;

            $this->updateCertificateRequestDispositionBy($request->id, $tempCertificateRequest);

            return response()->json([
                'error' => false,
                'status_code' => HttpStatusCodes::HTTP_OK,
                'message' => 'Berhasil memperbarui Ketua Tim',
            ], HttpStatusCodes::HTTP_OK);
        }

        if ($request->status === 'rejected') {
            $tempCertificateRequest['status'] = $request['status'];

            // Pass the correct argument type
            $tempCertificateRequestAssessment = $this->mappingDataLatestAssessment($request, $request->status);
            $tempCertificateRequestAssessment['assessor'] = $userId;
            $tempCertificateRequestAssessment['rejected_note'] = htmlspecialchars($request->rejected_note);
        }


        if ($request->status === 'disposition') {
            $tempCertificateRequest['disposition_by'] = $userId;
            $tempCertificateRequest['disposition_to'] = (int)$request->assessor;
            $tempCertificateRequest['status'] = $request->status;
        }

        if ($request->status === 'not_passed_assessment' || $request->status === 'passed_assessment') {
            $tempCertificateRequest['status'] = $request->status;

            $tempCertificateRequestAssessment['element_properties'] = $request->element_properties;
            $tempCertificateRequestAssessment['answers'] = $request->answers;
            $tempCertificateRequestAssessment['assessments'] = $request->assessments;
            $tempCertificateRequestAssessment['assessor'] = $userId;
            $tempCertificateRequestAssessment['status'] = $request->status;

            $companyId = CertificateRequest::where('id', $request->id)->value('company_id');

            if ($companyId && is_array($request->service_types)) {
                // Ambil daftar service_type_id yang sudah ada di database
                $existingServiceTypes = CompanyServiceType::where('company_id', $companyId)
                    ->pluck('service_type_id')
                    ->toArray();

                // Tentukan service_type_id untuk dihapus
                $toDelete = array_diff($existingServiceTypes, $request->service_types);

                // Tentukan service_type_id untuk ditambahkan
                $toInsert = array_diff($request->service_types, $existingServiceTypes);

                // Hapus data yang tidak ada di request
                if (!empty($toDelete)) {
                    CompanyServiceType::where('company_id', $companyId)
                        ->whereIn('service_type_id', $toDelete)
                        ->delete();
                }

                // Tambah data baru
                foreach ($toInsert as $serviceTypeId) {
                    CompanyServiceType::insert([
                        'company_id' => $companyId,
                        'service_type_id' => $serviceTypeId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Perbarui timestamp untuk data yang tetap ada
                $toUpdate = array_intersect($existingServiceTypes, $request->service_types);
                if (!empty($toUpdate)) {
                    CompanyServiceType::where('company_id', $companyId)
                        ->whereIn('service_type_id', $toUpdate)
                        ->update(['updated_at' => now()]);
                }
            }
        }

        if ($request->isValidAssessment) {
            $newStatus = 'passed_assessment_verification';

            // Pass the correct argument type
            $tempCertificateRequestAssessment = $this->mappingDataLatestAssessment($request, $newStatus);

            if ($request->isValidAssessment === 'no') {
                $tempCertificateRequestAssessment['validation_notes'] = htmlspecialchars($request->validation_notes);
                $newStatus = 'not_passed_assessment_verification';
            }


            $tempCertificateRequest['status'] = $newStatus;
        }

        $data = $this->updateCertificateRequest($request, $tempCertificateRequest, $tempCertificateRequestAssessment);

        if ($data) {
            return response()->json([
                'error' => false,
                'status_code' => HttpStatusCodes::HTTP_OK,
                'message' => 'Berhasil melakukan perubahan'
            ], HttpStatusCodes::HTTP_OK);
        }
    }

    public function getDetailByID($requestID)
    {
        return CertificateRequest::with([
            'company',
            'company.serviceTypes',
            'company.province',
            'company.city',
            'dispositionBy', // Ensure the 'dispositionBy' relation is loaded
            'dispositionTo', // Ensure the 'dispositionTo' relation is loaded
        ])
            ->leftJoin('certificate_request_assessments', function ($join) {
                $join->on('certificate_requests.id', 'certificate_request_assessments.certificate_request_id')
                    ->where('certificate_request_assessments.is_active', 1);
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
                'application_letters.file as file_of_application_letter',
            )
            ->where('certificate_requests.id', $requestID)
            ->first();
    }

    public function mappingDataLatestAssessment(Request $request, $newStatus = '')
    {
        $userId = $this->getModel($request);
        $data = [];

        $oldAssessment = $this->getLatestAssessmentByRequestID($request->id);

        // define $tempcertificateAssessment
        $data['element_properties'] = json_decode($oldAssessment->element_properties, true);
        $data['answers'] = json_decode($oldAssessment->answers, true);
        $data['assessor'] = $userId;
        $data['status'] = $newStatus;

        if ($oldAssessment->assessments) {
            $data['assessments'] = json_decode($oldAssessment->assessments, true);
        };

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

    public function updateCertificateRequest(Request $request, $tempCertificateRequest, $tempCertificateRequestAssessment)
    {

        $recipients = [];

        $latestAssessment = $this->getLatestAssessmentByRequestID($request->id);
        if (!empty($tempCertificateRequestAssessment)) {
            $newAssessment = $this->storeRequestAssessment($request->id, $tempCertificateRequestAssessment);
            $nonActiveOldAssessment = $this->nonActiveOldAssessment($latestAssessment->id);
        }

        if ($tempCertificateRequest['status'] === 'disposition') {
            $changeRequestStatus = $this->updateAssessor($request->id, $tempCertificateRequest);

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
            $changeRequestStatus = $this->changeRequestStatus($request->id, $tempCertificateRequest['status']);

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

        return true;
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
            $newData->validation_notes = strip_tags($request['validation_notes']);
        }

        if (array_key_exists('rejected_note', $request)) {
            $newData->rejected_note = strip_tags($request['rejected_note']);
        }

        $newData->save();

        return $newData;
    }

    public function nonActiveOldAssessment($assessmentID)
    {
        $oldData = $this->getAssessmentByID($assessmentID);
        $oldData->is_active = false;
        $oldData->save();

        return $oldData;
    }

    public function getAssessmentByID($id)
    {
        $data = CertificateRequestAssessment::select()
            ->where('id', $id)
            ->firstOrFail();

        return $data;
    }

    public function updateCertificateRequestDispositionBy($id, $request)
    {
        $newAssessorHead = $this->getCertificateRequestByID($id);

        $newAssessorHead->disposition_by = $request['disposition_by'];

        $newAssessorHead->update();

        return $newAssessorHead;
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
        $oldData->update();

        return $oldData;
    }

    public function totalPenilaian(Request $request)
    {

        // Ambil data sekaligus dengan grouping
        $data = CertificateRequest::selectRaw("
            SUM(CASE WHEN status = 'request' THEN 1 ELSE 0 END) as pengajuanAwalcoUNT,
            SUM(CASE WHEN status = 'certificate_validation' THEN 1 ELSE 0 END) as pengajuanSelesai,
            SUM(CASE WHEN status NOT IN ('request', 'draft', 'certificate_validation') THEN 1 ELSE 0 END) as prosesPengajuan
        ")
            ->get();

        // Format ulang hasil data
        $result = $data->map(function ($item) {
            return [
                'pengajuan_awal' => (int) $item->pengajuanAwalcoUNT,
                'proses_pengajuan' => (int) $item->pengajuanSelesai,
                'proses_selesai' => (int) $item->prosesPengajuan
            ];
        });

        return response()->json([
            'error' => false,
            'message' => 'User details retrieved successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $result
        ], HttpStatusCodes::HTTP_OK);
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
}
