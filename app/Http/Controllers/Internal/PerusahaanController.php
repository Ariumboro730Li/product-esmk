<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use App\Models\Company;
use App\Models\CompanyServiceType;
use App\Models\NibOss;
use App\Models\Province;
use App\Models\ServiceType;
use App\Models\StandardIndustrialClassification;
use App\Models\User;
use App\Models\YearlyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;
        $query = Company::orderBy('created_at', $meta['orderBy'])
            ->with(['province', 'city', 'serviceTypes'])
            ->leftJoin('certificate_requests', 'companies.id', '=', 'certificate_requests.company_id')
            ->select('companies.*', 'certificate_requests.status as certificate_status');


        if ($request->has('fromdate') && $request->has('duedate')) {
            $startDate = new \DateTime($request->fromdate);
            $endDate = new \DateTime($request->duedate);
            $interval = $startDate->diff($endDate);

            if ($interval->days > 31) {
                return ['error' => true, 'message' => 'Rentang tanggal tidak boleh lebih dari 31 hari'];
            }

            $startDate = $startDate->format('Y-m-d');
            $endDate = $endDate->format('Y-m-d');

            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween(DB::raw('DATE(companies.created_at)'), [$startDate, $endDate]);
            });
        }


        if ($request->filled('province')) {
            $query->where('province_id', $request->province);
        }

        if ($request->filled('service_type')) {
            // Ensure service_type is an array
            $serviceTypes = is_array($request->service_type) ? $request->service_type : [$request->service_type];

            $query->whereHas('serviceTypes', function ($q) use ($serviceTypes) {
                $q->whereIn('service_type_id', $serviceTypes);
            });
        }


        if ($request->filled('status')) {
            $query->where('certificate_requests.status', $request->status);
        }

        // Jika ada pencarian
        if ($request->search !== null) {
            $search = strtolower(trim($request->search));

            // Pencarian pada nama WorkUnit, Province, City, Level, ServiceTypes, Status, dan NIB
            $query->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"])
                    ->orWhereHas('province', function ($query) use ($search) {
                        $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
                    })
                    ->orWhereHas('city', function ($query) use ($search) {
                        $query->whereRaw("LOWER(nib) LIKE ?", ["%$search%"]);
                    });
            });
        }

        // Pagination data
        $data = $query->paginate($meta['limit']);

        // dd($data);
        $formattedData = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'username' => $item->username ?? null,
                'phone_number' => $item->phone_number ?? null,
                'email' => $item->email,
                'email_verified_at' => $item->email_verified_at ? Carbon::parse($item->email_verified_at)->format('Y-m-d') : null,
                'nib' => $item->nib,
                'nib_file' => $item->nib_file ?? '-',
                'province_id' => $item->province_id,
                'city_id' => $item->city_id,
                'address' => $item->address,
                'company_phone_number' => $item->company_phone_number ?? null,
                'pic_name' => $item->pic_name ?? null,
                'pic_phone' => $item->pic_phone ?? '-',
                'request_date' => $item->request_date ? Carbon::parse($item->request_date)->format('Y-m-d') : null,
                'approved_at' => $item->approved_at ? Carbon::parse($item->approved_at)->format('Y-m-d') : null,
                'approved_by' => $item->approved_by ?? null,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y-m-d') : null,
                'updated_at' => $item->updated_at ? Carbon::parse($item->updated_at)->format('Y-m-d') : null,
                'deleted_at' => $item->deleted_at ? Carbon::parse($item->deleted_at)->format('Y-m-d') : null,
                'established' => $item->established ? Carbon::parse($item->established)->format('Y-m-d') : null,
                'exist_spionam' => $item->exist_spionam ?? null,
                'certificate_status' => $item->certificate_status ?? null,
                'province' => [
                    'id' => $item->province->id ?? null,
                    'name' => $item->province->name ?? null,
                    'administrative_code' => $item->province->administrative_code ?? null,
                ],
                'city' => [
                    'id' => $item->city->id ?? null,
                    'province_id' => $item->city->province_id ?? null,
                    'name' => $item->city->name ?? null,
                    'administrative_code' => $item->city->administrative_code ?? null,
                ],
                'service_types' => $item->serviceTypes->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'name' => $service->name,
                        'pivot' => [
                            'company_id' => $service->pivot->company_id,
                            'service_type_id' => $service->pivot->service_type_id,
                        ]
                    ];
                })->toArray(),
            ];
        });

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $formattedData,
            // 'data' => $data->toArray()['data'],
            'paginate' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function show(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:companies,id',
            ],
            messages: [
                'id.required' => 'ID Di Perlukan',
                'id.exists' => 'ID Tidak Di Temukan',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Company::where('id', $request->id)
            ->with('province')
            ->with('city')
            ->with('serviceTypes')
            ->first();
        // $dataPengajuan = CertificateRequest::where('company_id', $data->id)->get();
        // $dataLaporanTahunan = YearlyReport::where('company_id', $data->id)->get();

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasill diTampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' =>  $data,
            // "pengajuan" => $dataPengajuan,
            // "laporanTahunan" => $dataLaporanTahunan,

        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function getPengajuan(Request $request)
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Mengatur meta parameter untuk pengurutan dan paginasi
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        // Pemetaan status dari Bahasa Inggris ke Bahasa Indonesia
        $statusMap = [
            'request' => 'Permintaan',
            'disposition' => 'Disposisi',
            'not_passed_assessment' => 'Tidak Lulus Penilaian',
            'passed_assessment' => 'Lulus Penilaian',
            'submission_revision' => 'Revisi Pengajuan',
            'not_passed_assessment_verification' => 'Tidak Lulus Verifikasi Penilaian',
            'assessment_revision' => 'Revisi Penilaian',
            'passed_assessment_verification' => 'Lulus Verifikasi Penilaian',
            'scheduling_interview' => 'Menjadwalkan Wawancara',
            'scheduled_interview' => 'Wawancara Dijadwalkan',
            'not_passed_interview' => 'Tidak Lulus Wawancara',
            'completed_interview' => 'Wawancara Selesai',
            'verification_director' => 'Verifikasi Direksi',
            'certificate_validation' => 'Validasi Sertifikat',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            'draft' => 'Draf'
        ];

        // Inisialisasi query CertificateRequest
        $query = CertificateRequest::with(['dispositionBy', 'dispositionTo', 'company'])
            ->select(
                'certificate_requests.*',
                'assessment_interviews.schedule as jadwal_wawancara',
                'companies.id as company_id',
                'companies.name as nama_perusahaan',
                DB::raw("CONCAT(YEAR(certificate_requests.created_at), '00000', certificate_requests.id) AS regnumber")
            )
            ->leftJoin('companies', 'certificate_requests.company_id', '=', 'companies.id')
            ->leftJoin('assessment_interviews', function ($join) {
                $join->on('certificate_requests.id', '=', 'assessment_interviews.certificate_request_id')
                    ->where('assessment_interviews.is_active', true);
            })
            ->where('certificate_requests.status', '!=', 'draft')
            ->where('certificate_requests.company_id', $request->id);

        // Jika ada pencarian berdasarkan disposition_by, disposition_to, atau status
        if ($request->has('search')) {
            $search = strtolower(trim($request->search));

            // Tambahkan kondisi untuk pencarian
            $query->where(function ($query) use ($search, $statusMap) {
                $query->whereHas('dispositionBy', function ($query) use ($search) {
                    $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
                })
                    ->orWhereHas('dispositionTo', function ($query) use ($search) {
                        $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
                    })
                    ->orWhere(function ($query) use ($search, $statusMap) {
                        // Cek apakah pencarian cocok dengan status dalam bahasa Indonesia
                        $filteredStatus = array_filter($statusMap, function ($status) use ($search) {
                            return strpos(strtolower($status), $search) !== false;
                        });

                        // Cari berdasarkan status yang ditemukan
                        if (!empty($filteredStatus)) {
                            $query->whereIn('certificate_requests.status', array_keys($filteredStatus));
                        }
                    });
            });
        }

        // Menambahkan orderBy dan paginasi
        $data = $query->orderBy('certificate_requests.created_at', $meta['orderBy'])
            ->paginate($meta['limit']);

        // Format data sesuai dengan contoh yang diberikan
        $formattedData = $data->map(function ($item) use ($statusMap) {
            return [
                'id' => $item->id,
                'company_id' => $item->company_id,
                'disposition_by' => [
                    'id' => $item->dispositionBy->id ?? null,
                    'name' => $item->dispositionBy->name ?? null,
                ],
                'disposition_to' => [
                    'id' => $item->dispositionTo->id ?? null,
                    'name' => $item->dispositionTo->name ?? null,
                ],
                'status' => $statusMap[$item->status] ?? $item->status, // Terjemahkan status ke Bahasa Indonesia
                'is_active' => $item->is_active,
                'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y-m-d') : null,
                'updated_at' => $item->updated_at ? Carbon::parse($item->updated_at)->format('Y-m-d') : null,
                'application_letter' => $item->application_letter ?? null,
                'schedule_interview' => $item->jadwal_wawancara ? Carbon::parse($item->jadwal_wawancara)->format('Y-m-d') : null,
                'nama_perusahaan' => $item->company->name ?? null,
                'regnumber' => $item->regnumber ?? null,
                'company' => [
                    'id' => $item->company->id ?? null,
                    'name' => $item->company->name ?? null,
                ]
            ];
        });

        // Return data dalam format JSON beserta paginasi
        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $formattedData,
            'paginate' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }

    public function getLaporanTahunan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Mengatur meta parameter untuk sorting dan paginasi
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        // Mappings status dalam bahasa Indonesia
        $statusMap = [
            'request' => 'Permintaan',
            'disposition' => 'Disposisi',
            'not_passed' => 'Tidak Lulus',
            'revision' => 'Revisi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'certificate_validation' => 'Pengesahan Sertifikat'
        ];

        // Query data YearlyReport dengan relasi
        $query = YearlyReport::with(['dispositionBy', 'dispositionTo', 'company', 'assessor'])
            ->where('company_id', $request->id)
            ->orderBy('created_at', $meta['orderBy']);

        // Pencarian berdasarkan status
        if ($request->search !== null) {
            $search = strtolower(trim($request->search));

            // Mapping pencarian status dengan statusMap
            $statusKey = array_search(ucwords($search), $statusMap);

            if ($statusKey !== false) {
                // Jika status yang dicari ada dalam statusMap, cari berdasarkan status
                $query->where('status', $statusKey);
            }
        }

        // Pagination data
        $data = $query->paginate($meta['limit']);

        // Mempersiapkan format data sesuai dengan contoh yang diberikan
        $formattedData = $data->map(function ($item) use ($statusMap) {
            return [
                'id' => $item->id,
                'company_id' => $item->company_id,
                'disposition_by' => [
                    'id' => $item->dispositionBy->id ?? null,
                    'name' => $item->dispositionBy->name ?? null,
                ],
                'disposition_to' => [
                    'id' => $item->dispositionTo->id ?? null,
                    'name' => $item->dispositionTo->name ?? null,
                    'approved_at' => $item->approved_at ? Carbon::parse($item->approved_at)->format('Y-m-d') : null,
                ],
                'status' => $statusMap[$item->status] ?? $item->status, // Status dalam Bahasa Indonesia
                'is_active' => $item->is_active,
                'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y-m-d') : null,
                'updated_at' => $item->updated_at ? Carbon::parse($item->updated_at)->format('Y-m-d') : null,
                'year' => $item->year,
                'company' => [
                    'id' => $item->company->id ?? null,
                    'name' => $item->company->name ?? null,
                ]
            ];
        });

        // Return data dalam format JSON beserta paginasi
        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $formattedData,
            'paginate' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }

    public function service(Request $request)
    {
        $service = ServiceType::select('id', 'name',)->get();
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
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $service,
        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function province()
    {
        $province = Province::select('id', 'name', 'administrative_code')->with('cities')->get();
        // dd($province);
        if (!$province) {

            return response()->json([
                'errors' => true,
                'message' => 'Data Tidak Di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $province,
        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function getCompanyKBLI(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:companies,id',
                'limit' => 'required|numeric|max:50',
            ],
            [
                'id.required' => 'ID Perusahaan diperlukan',
                'id.exists' => 'Perusahaan tidak ditemukan',
                'limit.required' => 'Limit diperlukan',
                'limit.numeric' => 'Limit harus angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $company = Company::select('nib')->where('id', $request->id)->first();

        $nib = NibOss::where('nib', $company->nib)->first();

        if (!$nib) {
            return response()->json([
                'error' => true,
                'message' => "NIB Tidak ditemukan",
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $dataKbli = $nib->data_nib;
        $kbliList = array_map(function ($item) {
            return [
                'kbli' => $item['kbli'],
                'uraian_usaha' => $item['uraian_usaha'] ?? null, // Tambahkan uraian usaha
            ];
        }, $dataKbli['data_proyek']);

        // Ambil daftar KBLI dari database
        $existKbli = StandardIndustrialClassification::pluck('kbli')->toArray();

        // Proses kecocokan KBLI
        $kbliWithMatch = array_map(function ($item) use ($existKbli) {
            return [
                'kbli' => $item['kbli'],
                'uraian_usaha' => $item['uraian_usaha'],
                'is_match' => in_array($item['kbli'], $existKbli) ? 1 : 0, // Cocok atau tidak
            ];
        }, $kbliList);


        $page = (int) $request->input('page', 1);
        $limit = (int) $request->input('limit', 10);
        $offset = ($page - 1) * $limit;

        $paginatedData = array_slice($kbliWithMatch, $offset, $limit);
        $totalItems = count($kbliWithMatch);
        $totalPages = ceil($totalItems / $limit);

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $paginatedData,
            'paginate' => [
                'total' => $totalItems,
                'count' => count($paginatedData),
                'per_page' => $limit,
                'current_page' => $page,
                'total_pages' => $totalPages,
            ],
        ], HttpStatusCodes::HTTP_OK);
    }


    public function countServiceType(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $serviceTypes = ServiceType::with(['companies' => function ($query) use ($year) {
            $query->whereYear('companies.created_at', $year);
        }])->get();
        $series = $serviceTypes->map(function ($serviceType) use ($year) {
            $monthlyData = array_fill(0, 12, 0);

            foreach ($serviceType->companies as $company) {
                $month = Carbon::parse($company->created_at)->month - 1;
                $monthlyData[$month]++;
            }

            return [
                'name' => $serviceType->name,
                'data' => $monthlyData
            ];
        });

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $series,
        ], HttpStatusCodes::HTTP_OK);
    }

     public function countPerusahaan(Request $request)
    {
        $counts = Company::selectRaw("
            COUNT(*) as total_perusahaan,
            SUM(CASE WHEN companies.exist_spionam = 1 THEN 1 ELSE 0 END) as terdaftar_spionam,
            SUM(CASE WHEN companies.exist_spionam = 0 OR exist_spionam IS NULL THEN 1 ELSE 0 END) as belum_terdaftar_spionam,
            SUM(CASE WHEN companies.is_active = 1 THEN 1 ELSE 0 END) as total_perusahaan_terverifikasi
        ")->
        leftJoin('certificate_requests', 'companies.id', '=', 'certificate_requests.company_id')
        ->first();

        $response = [
            'total_perusahaan' => (int) $counts->total_perusahaan,
            'terdaftar_spionam' => (int) $counts->terdaftar_spionam,
            'belum_terdaftar_spionam' => (int) $counts->belum_terdaftar_spionam,
            'total_perusahaan_terverifikasi' => (int) $counts->total_perusahaan_terverifikasi,
        ];

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $response,
        ], HttpStatusCodes::HTTP_OK);
    }
}
