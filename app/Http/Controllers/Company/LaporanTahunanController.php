<?php

namespace App\Http\Controllers\Company;

use Auth;
use App\Models\Company;
use App\Models\YearlyReport;
use Illuminate\Http\Request;
use App\Models\MonitoringElement;
use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LaporanTahunanController extends Controller
{


    public function index(Request $request)
    {
        $id = $this->getModel($request);

        $companyID = Company::where('id', $id)->value('id');

        $data = $this->getYearlyReportHistory($companyID, $request->input('search'), $request);

        return response()->json($data->original);

    }

    public function getYearlyReportHistory($companyID, $search = null, $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        $query = YearlyReport::select(
            'id',
            'year',
            'status',
            'assessor',
            'company_id',
            'created_at',
            'approved_at'
        )
            ->with('assessor')
            ->where('company_id', $companyID)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc');

        // Menambahkan filter berdasarkan search jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('status', 'like', '%' . $search . '%')
                    ->orWhere('year', 'like', '%' . $search . '%')
                    ->orWhereHas('assessor', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $data = $query->paginate($meta['limit']);

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

    public function getFirstMonitoringElement()
    {
        $data = MonitoringElement::select()->first();
        if (!is_null($data)) {
            $data = MonitoringElement::select()
            ->where('is_active', true)
            ->first();
        } else {
            $data = new MonitoringElement();
        }

        return $data;
    }

    public function getMonitoringElements(Request $request)
    {

        $monitoringElements = $this->getFirstMonitoringElement();

        if ($monitoringElements) {
            $data = [
                'id' => $monitoringElements->id,
                'element_properties' => json_decode($monitoringElements->element_properties),
                'monitoring_elements' => json_decode($monitoringElements->monitoring_elements),
                'additional_questions' => json_decode($monitoringElements->additional_questions)
            ];
            return response()->json([
                'message' => 'Sukses Membuat Data Laporan',
                'status' => true,
                'data' => $data
            ], HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Element Pemantauan Tidak Ditemukan, Silakan Hubungi Administrator',
                'status' => false,
                'data' => []
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
    }

    public function storeNewReport($request)
    {
        $newData = new YearlyReport();
        $newData->company_id = $request->company_id;
        $newData->year = $request->year;
        $newData->monitoring_element_id = $request->monitoring_element_id;
        $newData->status = $request->status;
        $newData->answers = json_encode($request->answers, true);
        $newData->save();

        return $newData;
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer',
            'monitoring_element_id' => 'required|integer',
            'answers' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $id = $this->getModel($request);
        $request['company_id'] = Company::where('id', $id)->value('id');
        $request['status'] = 'request';

        $data = $this->storeNewReport($request);

        if($data){
            return response()->json([
                'message' => 'Sukses Membuat Data Laporan',
                'status' => true,
                'data' => $data
            ], HttpStatusCodes::HTTP_OK);
        }

    }
    public function getLatestReports($companyID)
    {
        $data = YearlyReport::select('id', 'year')
            ->where('company_id', $companyID)
            ->where('is_active', true)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->orderBy('year', 'desc')
            ->first();
        return $data;
    }


    public function getLatestReport(Request $request)
    {

        $id = $this->getModel($request);
        $companyID = Company::where('id', $id)->value('id');

        $latestReport = $this->getLatestReports($companyID);

        return response()->json($latestReport);
    }

    public function show(Request $request)
    {
        $id = $this->getModel($request);
        $companyID = Company::where('id', $id)->value('id');
        $yearlyReport = YearlyReport::select(
            'additional_questions',
            'answers',
            'assessments',
            'element_properties',
            'monitoring_elements',
            'year',
            'status',
        )->join('monitoring_elements', 'monitoring_element_id', 'monitoring_elements.id')
            ->where('company_id', $companyID)
            ->where('yearly_reports.id', $request->id)
            ->first();

        if (!$yearlyReport) {
            return response()->json([
                'status' => HttpStatusCodes::HTTP_NOT_FOUND,
                'message' => 'Data Tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $data = [
            'additional_questions' => json_decode($yearlyReport->additional_questions),
            'answers' => json_decode($yearlyReport->answers),
            'assessments' => json_decode($yearlyReport->assessments),
            'element_properties' => json_decode($yearlyReport->element_properties),
            'monitoring_elements' => json_decode($yearlyReport->monitoring_elements),
            'year' => $yearlyReport->year,
            'status' => $yearlyReport->status,
        ];

        if($data){
            return response()->json([
                'error' => false,
                'message' => 'Data Laporan Berhasil Berhasil Didapat',
                'status_code' => HttpStatusCodes::HTTP_OK,
                'data' => $data
            ], HttpStatusCodes::HTTP_OK);
        }
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
            'message'       => "Successfully",
            'data'          => array(
                'certificate_file_base64'   => "data:application/pdf;base64," . $b64Doc
            )
        ], HttpStatusCodes::HTTP_OK);
    }



    public function getDetailByID(Request $request)
    {
        $data = YearlyReport::select()
            ->where('id', $request->id)
            ->firstOrFail();

        return $data;
    }

    public function updateReport($request)
    {
        $newData = $this->getDetailByID($request);
        $newData->status = $request->status;
        $newData->answers = json_encode($request->answers, true);
        $newData->save();

        return $newData;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answers' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $id = $this->getModel($request);
        $companyID = Company::where('id', $id)->value('id');

        if (!$companyID) {
            return response()->json([
                'message' => 'Perusahaan tidak ditemukan',
                'status' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $request['company_id'] = $companyID;
        $request['status'] = 'revision';

        $data = $this->updateReport($request);

        if ($data) {
            return response()->json([
                'message' => 'Data berhasil diubah',
                'status' => HttpStatusCodes::HTTP_OK,
                'data' => $data,
            ], HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'status' => HttpStatusCodes::HTTP_BAD_REQUEST,
                'message' => 'Gagal Update Data.'
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

    }
}
