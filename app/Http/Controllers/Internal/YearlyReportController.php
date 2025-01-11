<?php

namespace App\Http\Controllers\Internal;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\WorkUnit;
use App\Models\YearlyReport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Constants\HttpStatusCodes;
use App\Models\WorkUnitHasService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class YearlyReportController extends Controller
{

    public function index(Request $request): JsonResponse
    {

        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        // Membuat query dengan hanya kolom yang dibutuhkan
        $query = YearlyReport::select('id', 'year as tahun_laporan', 'status', 'approved_at as tanggal_verifikasi', 'assessor', 'company_id', 'created_at')
            ->with([
                'company:id,name',
                'dispositionBy:id,name',
                'assessor:id,name',
            ])
            ->orderBy('created_at', $meta['orderBy']);

        // Filter berdasarkan tanggal
        if ($request->filled('fromdate')) {
            $fromDate = Carbon::parse($request->fromdate)->format('Y-m-d');
            $query->where('created_at', '>=', $fromDate);
        }

        if ($request->filled('duedate')) {
            $dueDate = Carbon::parse($request->duedate)->format('Y-m-d');
            $query->where('created_at', '<=', $dueDate);
        }


        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('company', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }


        $data = $query->paginate($meta['limit']);
        // dd($data);

        $formattedData = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'company_id' => $item->company_id,
                'nama_perusahaan' => $item->company->name ?? null,
                'tahun_laporan' => $item->tahun_laporan,
                'status' => $item->status,
                'tanggal_verifikasi' => Carbon::parse($item->approved_at)->format('Y-m-d'),
                'diverifikasi_oleh' => $item,
                'created_at' => Carbon::parse($item->created_at)->format('Y-m-d')
            ];
        });
        // dd($formattedData);

        // Mengembalikan response dengan pagination
        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $formattedData,
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }

    public function getDetailByID(Request $request)
    {
        $data = YearlyReport::with([
            'company.serviceTypes',
            'company.province',
            'company.city',
            'company'
        ])
            ->join('monitoring_elements', 'monitoring_element_id', 'monitoring_elements.id')
            ->select(
                'yearly_reports.*',
                'assessor',
                'monitoring_elements.element_properties as element_properties',
                'monitoring_elements.monitoring_elements as monitoring_elements',
                'monitoring_elements.additional_questions as additional_questions',
                'assessments',
                'answers',
                'approved_at',
                'yearly_reports.created_at as created_at'
            )
            ->where('yearly_reports.id', $request->id)
            ->first();

        return $data;
    }

    public function show(Request $request)
    {
        $result['status'] = 200;

        $id = $this->getModel($request);
        $companyID = Company::where('id', $id)->value('id');

        $yearlyReportData = $this->getDetailByID($request);


        if (!$yearlyReportData) {
            return response()->json([
                'status' =>  HttpStatusCodes::HTTP_BAD_REQUEST,
                'message' => 'Laporan Tahunan Tidak Ditemukan.'
            ],  HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = [
            'company' => $yearlyReportData->company,
            'year' => $yearlyReportData->year,
            'monitoring_elements' => json_decode($yearlyReportData->monitoring_elements, true),
            'element_properties' => json_decode($yearlyReportData->element_properties, true),
            'additional_questions' => json_decode($yearlyReportData->additional_questions, true),
            'status' => $yearlyReportData->status,
            'assessor' => $yearlyReportData->assessor,
            'assessments' => json_decode($yearlyReportData->assessments, true),
            'answers' => json_decode($yearlyReportData->answers, true),
            'approved_at' => $yearlyReportData->approved_at,
            'created_at' => $yearlyReportData->created_at,
        ];

        return response()->json([
            'error' => false,
            'message' => 'Data Laporan Tahunan Didapatkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }


    public function getFileUrlToBase64(Request $term)
    {
        $validator = Validator::make($term->all(), [
            'url'     => 'required|url'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $confGetContent = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $b64Doc = chunk_split(base64_encode(file_get_contents($term->url, false, stream_context_create($confGetContent))));
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Berhasil",
            'data'          => array(
                'certificate_file_base64'   => "data:application/pdf;base64," . $b64Doc
            )
        ], HttpStatusCodes::HTTP_OK);
    }

    public function getDetail(Request $request)
    {
        // Ambil YearlyReport dengan filter berdasarkan workunit
        $data = YearlyReport::with(['company'])
            ->where('id', $request->id)
            ->first();

        // Jika tidak ditemukan, kembalikan respons 404
        if (!$data) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'YearlyReport tidak ditemukan.'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        return $data; // Return the model directly
    }

    public function updateAssessment(Request $request)
    {
        $oldData = $this->getDetail($request);

        if ($oldData) {
            $oldData->status = $request->assessment_status;
            $oldData->assessments = $request->assessments;
            $oldData->assessor = $request->assessor;
            $oldData->approved_at = $request['approved_at'];
            $oldData->save();

            return response()->json($oldData);
        } else {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'YearlyReport tidak ditemukan.'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
    }


    public function update(Request $request)
    {
        // Retrieve user from request
        $authAppData = auth();
        $user = User::where('id', $authAppData->user()->id)->first();

        // Validation
        $validator = Validator::make($request->all(), [
            'assessments' => 'required',
            'assessment_status' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Additional data processing
        $request['assessor'] = $user->id;
        $request['approved_at'] = $request['assessment_status'] === 'verified' ? Carbon::now() : null;

        // Use a helper method to get and update the assessment
        $yearlyReportData = $this->updateAssessment($request);

        // If updateAssessment returns null, assume data was not found
        if (!$yearlyReportData) {
            return response()->json([
                'status_code' => 404,
                'error' => true,
                'message' => 'Yearly Report not found',
            ], 404);
        }

        // Return success response
        return response()->json([
            'status_code' => 200,
            'error' => false,
            'message' => 'Assessment updated Berhasil',
            'data' => $yearlyReportData
        ], 200);
    }

    public function countData(Request $request)
    {
        $countData = YearlyReport::selectRaw("
            COUNT(*) as total_pengajuan,
            SUM(CASE WHEN status = 'revision' THEN 1 ELSE 0 END) as total_revisi,
            SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as total_terverifikasi
        ")->first();

        // Pastikan data berupa angka
        $response = [
            'total_pengajuan' => (int) $countData->total_pengajuan,
            'total_revisi' => (int) $countData->total_revisi,
            'total_terverifikasi' => (int) $countData->total_terverifikasi,
        ];

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'data' => $response,
        ]);
    }
}
