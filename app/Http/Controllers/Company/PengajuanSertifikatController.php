<?php

namespace App\Http\Controllers\Company;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\ApplicationLetter;
use App\Models\CertificateRequest;
use App\Jobs\NotificationUser;
use App\Models\CertificateRequestAssessment;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Jobs\NotificationAll;
use App\Models\AssessmentInterview;

class PengajuanSertifikatController extends Controller
{
    public function getCertifiateActive(Request $request)
    {
        $companyId = $this->getModel($request);
        $data = $this->getCertificateRequestActiveByCompanyID($companyId);
        if ($data) {
            $message = 'Data pengajuan sertifikat ditemukan';
        } else {
            $message = 'Data pengajuan sertifikat tidak ditemukan';
            $data = [];
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
            'ascending' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Meta data untuk sorting dan paginasi
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit <= 30 ? $request->limit : 30;
        $userId = $this->getModel($request);

        // Query awal
        $query = CertificateRequest::select(
            'certificate_requests.*',
            'number_of_application_letter'
        )->with('company.serviceTypes')
            ->leftJoin('application_letters', 'certificate_requests.id', 'application_letters.certificate_request_id')
            ->where('company_id', $userId);

        // Menambahkan filter search jika ada
        if ($request->has('search') && !empty(trim($request->search))) {
            $search = strtolower(trim($request->search));
            $query->whereRaw("LOWER(number_of_application_letter) LIKE ?", ["%$search%"]);
        }

        // Menambahkan order by dan paginasi
        $data = $query->orderBy('certificate_requests.created_at', $meta['orderBy'])->paginate($meta['limit']);

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }


    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'answers' => 'required',
            'element_properties' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }


        $request['request_status'] = $request->status;
        $request['assessment_status'] = $request->status;

        $data = $this->storeNewRequest($request);


        // Kembalikan respons sukses
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dibuat',
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:certificate_requests,id',
            'answers' => 'required',
            'element_properties' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $request['company_id'] = $this->getModel($request);
        $request['request_status'] = $request->status;
        $request['assessment_status'] = $request->status;

        $data = $this->storeRevision($request->id, $request);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah',
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    public function detail(Request $request)
    {
        $company_id = $this->getModel($request);

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:certificate_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $certificateRequest = CertificateRequest::where('id', $request->id)
            ->where('company_id', $company_id)
            ->exists();

        if (!$certificateRequest) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $companyInfo = Company::with('serviceTypes')->where('id', $company_id)->first();

        $certificateRequest = $this->getCertificateRequestAndLatestAssessmentByRequestID($request->id);

        $data = [
            'request_status' => $certificateRequest->request_status,
            'assessment_status' => $certificateRequest->assessment_status,
            'element_properties' => json_decode($certificateRequest->element_properties),
            'answers' => json_decode($certificateRequest->answers),
            'assessments' => json_decode($certificateRequest->assessments),
            'assessment_interviews' => $this->getAssessmentInterview($request->id),
            'rejected_note' => $certificateRequest->rejected_note,
            'number_of_application_letter' => $certificateRequest->number_of_application_letter,
            'date_of_application_letter' => $certificateRequest->date_of_letter,
            'file_of_application_letter' => $certificateRequest->file_of_application_letter,
            'company_info' => $companyInfo
        ];

        return response()->json([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    public function getCertificateRequestActiveByCompanyID($companyID)
    {
        $smkCertificate = CertificateRequest::select()
            ->where('company_id', $companyID)
            ->whereIn('status', [
                'draft',
                'rejected',
                'request',
                'disposition',
                'not_passed_assessment',
                'submission_revision',
                'passed_assessment',
                'not_passed_assessment_verification',
                'passed_assessment_verification',
                'scheduling_interview',
                'scheduled_interview',
                'completed_interview',
                'verification_director',
                'certificate_validation',
            ])->first();

        return $smkCertificate;
    }
    public function storeRevision($certificateRequestID, $request)
    {


        $latestAssessment = $this->getCertificateRequestAndLatestAssessmentByRequestID($certificateRequestID);
        $oldAssessment = $this->changeStatusAssesment($latestAssessment->assessment_id);
        $certicateAssessment = $this->storeRequestAssessment($certificateRequestID, $request);
        $certificateRequest = $this->changeStatusCertificateRequest($certificateRequestID, $request['request_status']);

        if (
            $request['request_status'] === 'draft'
            || $request['request_status'] === 'request'
        ) {
            $applicationLetter = ApplicationLetter::where('certificate_request_id', $latestAssessment->id)->first();
            $model = ApplicationLetter::find($applicationLetter->id);
            $model->number_of_application_letter = strip_tags($request->number_of_application_letter);
            $model->date_of_letter = $request->date_of_application_letter;
            $model->file = $request->file_of_application_letter;
            $model->save();
        }

        $currentDate = Carbon::now()->timestamp;

        if ($request->request_status === 'submission_revision') {
            $newTopicForCompany = "notification-employee-{$certificateRequest->disposition_to}";
            dispatch(new NotificationUser([
                [
                    'type'        => 'success',
                    'title'       => 'Revisi pengajuan',
                    'description' => $certificateRequest->company->name . ' telah melakukan perbaikan dokumen pengajuan.',
                    'delivery_at' => $currentDate
                ]
            ]))->delay(Carbon::now()->addSeconds(3));
        }
        return $certificateRequest;
    }


    public function changeStatusCertificateRequest($requestID, $status)
    {
        $oldData = $this->getCertificateRequestDetailByID($requestID);
        $oldData->status = $status;
        $oldData->save();

        return $oldData;
    }

    public function getCertificateRequestDetailByID($requestID)
    {
        $data = CertificateRequest::select()
            ->where('id', $requestID)
            ->firstOrFail();

        return $data;
    }

    public function getAssessmentInterview($certificate_request_id)
    {
        return AssessmentInterview::select()->with(['certificateRequest', 'assessorHead', 'assessor1', 'assessor2'])->where('certificate_request_id', $certificate_request_id)->where('is_active', true)->first() ?? collect();
    }

    public function changeStatusAssesment($assessmentID)
    {
        $oldData = $this->getAssessmentDetailByID($assessmentID);
        $oldData->is_active = false;
        $oldData->save();

        return $oldData;
    }

    public function getAssessmentDetailByID($requestID)
    {
        $data = CertificateRequestAssessment::select()
            ->where('id', $requestID)
            ->firstOrFail();

        return $data;
    }

    public function getCertificateRequestAndLatestAssessmentByRequestID($id)
    {
        $data = CertificateRequest::select(
            'certificate_requests.id as id',
            'certificate_request_assessments.id as assessment_id',
            'certificate_requests.status as request_status',
            'certificate_request_assessments.status as assessment_status',
            'certificate_requests.application_letter as application_letter',
            'element_properties',
            'answers',
            'assessments',
            'rejected_note',
            'number_of_application_letter',
            'date_of_letter',
            'application_letters.file as file_of_application_letter'
        ) ->with(['company.serviceTypes'])
            ->join('certificate_request_assessments', 'certificate_request_assessments.certificate_request_id', 'certificate_requests.id')
            ->rightjoin('application_letters', 'application_letters.certificate_request_id', 'certificate_requests.id')
            ->where('certificate_requests.id', $id)
            ->where('certificate_requests.is_active', true)
            ->where('certificate_request_assessments.is_active', true)
            ->orderBy('certificate_request_assessments.created_at', 'desc')
            ->first();

        return $data;
    }
    public function storeNewRequest(Request $request)
    {

        $companyID = $this->getModel($request);

        $certificateRequest = $this->storeCertificateRequest($request);
        $certicateAssessment = $this->storeRequestAssessment($certificateRequest->id, $request);


        $model = new ApplicationLetter();
        $model->certificate_request_id = $certificateRequest->id;
        $model->number_of_application_letter = strip_tags($request->number_of_application_letter);
        $model->date_of_letter = $request->date_of_application_letter;
        $model->file = $request->file_of_application_letter;
        $model->save();

        $company = Company::find($companyID);

        if ($request->request_status == 'request') {
            dispatch(new NotificationAll([
                'title'       => 'New Request',
                'description' => 'Perusahaan ' . $company->name . ' telah melakukan pengajuan sertifikat SMK.',
                'data'        => []
            ]))->delay(Carbon::now()->addSeconds(3));
        }


        return $certificateRequest;
    }

    public function storeCertificateRequest($request)
    {
        $company_id = $this->getModel($request);
        $newData = new CertificateRequest();
        $newData->company_id = $company_id;
        $newData->application_letter = $request->application_letter;
        $newData->status = $request->request_status;
        $newData->save();

        return $newData;
    }

    public function storeRequestAssessment($certificateRequestID, $request)
    {
        $newData = new CertificateRequestAssessment();
        $newData->certificate_request_id = $certificateRequestID;
        $newData->element_properties = json_encode($request->element_properties, true);
        $newData->answers = json_encode($request->answers, true);
        $newData->status = $request->assessment_status;

        if ($request->assessments) {
            $newData->assessments = json_encode($request->assessments, true);
        }

        if ($request->revision) {
            $newData->revision = $request->revision;
        }

        $newData->save();

        return $newData;
    }
}
