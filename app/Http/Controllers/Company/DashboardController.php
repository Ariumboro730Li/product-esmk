<?php

namespace App\Http\Controllers\Company;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\CertificateSmk;
use App\Models\Company;
use App\Models\NibOss;
use App\Models\ServiceType;
use App\Models\StandardIndustrialClassification;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function getUserDetails(Request $request)
    {
        $authAppData = $this->getModel($request);
        $user = Company::where('id', $authAppData)->first();

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $user,
        ], HttpStatusCodes::HTTP_OK);
    }
    public function perusahaan(Request $request)
    {
        $Id = $this->getModel($request);
        $companyIds = Company::where('companies.id', $Id)
            ->with([
                'province' => function ($query) {
                    $query->select('id', 'name', 'administrative_code'); // Memilih hanya kolom id dan name dari province
                },
                'city' => function ($query) {
                    $query->select('id', 'name', 'administrative_code'); // Memilih hanya kolom id dan name dari city
                }
            ])
            ->select('companies.*', 'users.email as email')
            ->join('users', 'companies.user_id', '=', 'users.id')
            ->with('serviceTypes')
            ->first();


        if (!$companyIds) {
            return response()->json([
                'error' => true,
                'message' => 'Data Perusahaan Tidak Di Temukan',
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $companyIds
        ]);
    }

    public function getsmk(Request $request)
    {
        $Id = $this->getModel($request);

        // Find the company by ID
        $company = Company::where('id', $Id)->first();

        // If the company is not found, return response with null values
        if (!$company) {
            return response()->json([
                'error' => false,
                'message' => 'Data Tidak Ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Fetch the certificate data associated with the company
        $certificate = CertificateSmk::where('company_id', $company->id)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        // If the certificate is not found, return response with null values
        if (!$certificate) {
            return response()->json([
                'error' => false,
                'message' => 'Data Tidak Ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Structure the response data as per the requested format
        $responseData = [
            'id' => $certificate->id,
            'certificate_request_id' => $certificate->certificate_request_id,
            'certificate_file' => $certificate->certificate_file,
            'publish_date' => $certificate->publish_date,
            'expired_date' => $certificate->expired_date,
            'rov_file' => $certificate->rov_file,
            'sk_file' => $certificate->sk_file,
            'company_id' => $certificate->company_id,
            'is_active' => (bool) $certificate->is_active,
            'created_at' => $certificate->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $certificate->updated_at->format('Y-m-d H:i:s'),
            'number_of_certificate' => $certificate->number_of_certificate,
            'sign_by' => $certificate->sign_by,
            'certificate_digital_url' => $certificate->certificate_digital_url,
        ];

        // Return the response in JSON format with status 200
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $responseData,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function dataKbli(Request $request)
    {


        $Id = $this->getModel($request);
        $company = Company::where('id', $Id)->first();
        $nib = NibOss::where('nib', $company->nib)->first();
        if (!$nib) {
            return response()->json([
                'error' => true,
                'message' => "NIB Tidak ditemukan",
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $dataKbli = $nib->data_nib;
        $dataKbli = $nib->data_nib;
        if ($request->search !== null) {
            $search = strtolower(trim($request->search));
            $dataKbli['data_proyek'] = array_filter($dataKbli['data_proyek'], function ($item) use ($search) {
                if (isset($item['uraian_usaha']) && strpos(strtolower($item['uraian_usaha']), $search) !== false) {
                    return true;
                }
                if (isset($item['kbli']) && strpos(strtolower($item['kbli']), $search) !== false) {
                    return true;
                }
                if (isset($item['data_proyek_produk'][0]['jenis_produksi']) && strpos(strtolower($item['data_proyek_produk']['jenis_produksi']), $search) !== false) {
                    return true;
                }
                return false;
            });
        }
        $kbliList = array_map(function ($item) {
            return [
                'kbli' => $item['kbli'],
                'uraian_usaha' => $item['uraian_usaha'] ?? null,
                'jenis_produksi' => ucwords($item['data_proyek_produk'][0]['jenis_produksi']) ?? null,
            ];
        }, $dataKbli['data_proyek']);
        $existKbli = StandardIndustrialClassification::pluck('kbli')->toArray();
        $kbliWithMatch = array_map(function ($item) use ($existKbli) {
            return [
                'kbli' => $item['kbli'],
                'uraian_usaha' => $item['uraian_usaha'],
                'jenis_produksi' => $item['jenis_produksi'] ?? null,
                'is_match' => in_array($item['kbli'], $existKbli) ? 1 : 0,
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

}
