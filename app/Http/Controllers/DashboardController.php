<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Assessor;
use App\Models\Auth\Role;
use App\Models\CertificateRequest;
use App\Models\Company;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\WorkUnit;
use App\Models\WorkUnitHasService;
use App\Models\YearlyReport;
use App\Models\YearlyReportLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DashboardController extends Controller
{
    protected $service;
    public function __construct()
    {
        App::setLocale('id');
    }

    public function getDataDashboard(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $request->merge([
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => 200,
            'data' => [
                'companies' => $this->company($request),
                'certificate_requests' => $this->certificateRequest($request),
                'service_types' => $this->serviceTypes($request),
            ]
        ]);
    }

    public function company(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $queryCompany = Company::with('serviceTypes');
        $queryCompany->whereBetween('created_at', [$dateFrom, $dateTo]);
        return $queryCompany->get();
    }

    public function serviceTypes(Request $request)
    {
        $dateFrom   = $request->dateFrom;
        $dateTo     = $request->dateTo;

        $query =  ServiceType::with([
            'companies' => function ($subQuery) use ($dateFrom, $dateTo) {
                return $subQuery->whereBetween('companies.created_at', [$dateFrom, $dateTo]);
            }
        ])
            ->select()
            ->orderBy('service_types.name', 'asc');
        return $query->get();
    }

    public function certificateRequest(Request $request)
    {
        $dateFrom   = $request->dateFrom;
        $dateTo     = $request->dateTo;

        $queryCertificateRequest = CertificateRequest::with('company')
            ->whereBetween('certificate_requests.created_at', [$dateFrom, $dateTo])
            ->where('certificate_requests.status', '!=', 'draft');
        return $queryCertificateRequest->get();
    }

    public function yearlyReport(Request $request)
    {
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit <= 30 ? $request->limit : 30;
        $currentDate = Carbon::now()->subMonths(1)->format('Y-m-d');

        // Query utama untuk yearlyReport
        $yearlyReport = YearlyReportLog::with('company')
            ->whereDate('due_date', '<', $currentDate)
            ->where('is_completed', 0);

        // Menambahkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = strtolower(trim($request->search));
            $yearlyReport->whereHas('company', function ($subQuery) use ($searchTerm) {
                $subQuery->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
            });
        }

        $data = $yearlyReport->orderBy('updated_at', $meta['orderBy'])->paginate($meta['limit']);
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

    public function getListAssesor(Request $request)
    {
        // Menentukan sorting dan limit
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit <= 30 ? $request->limit : 30;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $queryUser = User::select(
            "name","nip"
        )
            ->withCount([
                'certificate_request_disposisition' => function ($query) use ($dateFrom, $dateTo) {
                    return $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                },
                'certificate_request_disposition_process' => function ($query) use ($dateFrom, $dateTo) {
                    return $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                },
                'certificate_request_completed' => function ($query) use ($dateFrom, $dateTo) {
                    return $query->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            ])
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Assessor');
            });

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = strtolower(trim($request->search));
            $queryUser->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
        }
        if ($request->has('dateFrom') && $request->has('dateTo')) {
            $dateFrom = $request->input('dateFrom');
            $dateTo = $request->input('dateTo');
            $queryUser->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);
        }
        $data = $queryUser->orderBy('name', $meta['orderBy'])->paginate($meta['limit']);
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

    public function getUserDetails(Request $request): JsonResponse
    {
        $authAppData = auth();
        $user = User::where('id', $authAppData->user()->id)->first();
        $roles = $user->getRoleNames();

        return response()->json([
            'error' => false,
            'message' => 'User details retrieved successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $roles
                ],
            ],
        ], HttpStatusCodes::HTTP_OK);
    }

    public function totalPenilaian(Request $request)
    {
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;

        // Ambil data sekaligus dengan grouping
        $data = CertificateRequest::selectRaw("
            DATE(created_at) as date,
            SUM(CASE WHEN status = 'request' THEN 1 ELSE 0 END) as pengajuanAwalcoUNT,
            SUM(CASE WHEN status = 'certificate_validation' THEN 1 ELSE 0 END) as pengajuanSelesai,
            SUM(CASE WHEN status NOT IN ('request', 'draft', 'certificate_validation') THEN 1 ELSE 0 END) as prosesPengajuan
        ")
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        // Format ulang hasil data
        $result = $data->map(function ($item) {
            return [
                'date' => $item->date,
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
}
