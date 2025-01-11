<?php

namespace App\Http\Controllers\MasterData;

use App\Console\Commands\YearlyReport;
use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\ServiceType;
use App\Models\WorkUnit;
use App\Models\WorkUnitHasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WorkUnitController extends Controller
{
    public function __construct() {}
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'nullable|numeric|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;
        // Query utama dengan relasi province, city, dan serviceTypes
        $query = WorkUnit::orderBy('created_at', $meta['orderBy'])
            ->with(['province', 'city', 'serviceTypes']);

        if ($request->search !== null) {
            $search = strtolower(trim($request->search));

            // Pencarian pada nama WorkUnit, Province, City, dan Level
            $query->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"])
                    ->orWhereHas('province', function ($query) use ($search) {
                        $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
                    })
                    ->orWhereHas('city', function ($query) use ($search) {
                        $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
                    })
                    ->orWhereHas('serviceTypes', function ($query) use ($search) {
                        // Pencarian pada serviceTypes berdasarkan name
                        $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
                    })
                    ->orWhere(function ($query) use ($search) {
                        // Mapping level numerik ke label string
                        $levelMap = [
                            '1' => 'kementrian',
                            '2' => 'dishub provinsi',
                            '3' => 'dishub kota/kabupaten'
                        ];

                        // Melakukan pencarian pada level yang sesuai dengan pencarian user
                        foreach ($levelMap as $level => $label) {
                            $query->orWhereRaw("level = ? AND LOWER(?) LIKE ?", [$level, $label, "%$search%"]);
                        }
                    });
            });
        }

        // Pagination data
        $data = $query->paginate($meta['limit']);
        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data->toArray()['data'],
            'paginate' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function province(Request $request)
    {
        // Mulai query untuk province dengan relasi ke cities
        $query = Province::select('id', 'name', 'administrative_code')->with('cities');

        // Jika ada parameter 'search', lakukan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower(trim($request->search));

            // Tambahkan kondisi pencarian pada query
            $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
        }

        // Eksekusi query dan ambil hasilnya
        $provinces = $query->get();

        // Jika data tidak ditemukan, kembalikan response dengan status 404
        if ($provinces->isEmpty()) {
            return response()->json([
                'errors' => true,
                'message' => 'Data Tidak Ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Jika data ditemukan, kembalikan response dengan status 200
        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $provinces,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function city(Request $request)
    {
        $query = City::where('province_id', $request->id)->select('id', 'name',);

        // Jika ada parameter 'search', lakukan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower(trim($request->search));

            // Tambahkan kondisi pencarian pada query
            $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
        }

        // Eksekusi query dan ambil hasilnya
        $citys = $query->get();

        // dd($province);
        if (!$citys) {

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
            'data' => $citys,
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function service(Request $request)
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
    public function store(Request $request)
    {
        // dd($request->service_type_id);
        // Validasi request
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'level' => 'required|string|max:255',
                'province_id' => 'required|integer',
                'city_id' => 'required|integer',
                'address' => 'required|string',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'email' => 'required|email|max:255|unique:work_units,email', // Pastikan email unik
                'phone_number' => 'required|digits_between:10,15|numeric',
                'service_type_id' => 'required|array',
                'service_type_id.*' => 'integer|exists:service_types,id',
            ],
            [
                'name.required' => 'Nama Di Perlukan',
                'level.required' => 'Level Di Perlukan',
                'province_id.required' => 'Provinsi Di Perlukan',
                'city_id.required' => 'Kota Di Perlukan',
                'address.required' => 'Alamat Di Perlukan',
                'longitude.numeric' => 'Longitude harus berupa angka',
                'latitude.numeric' => 'Latitude harus berupa angka',
                'email.required' => 'Email Di Perlukan',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'phone_number.digits_between' => 'Nomor Telepon harus antara 10 sampai 15 digit',
                'phone_number.numeric' => 'Nomor Telepon harus berupa angka',
                'service_type_id.array' => 'Jenis Layanan harus berupa array',
                'service_type_id.*.integer' => 'ID Jenis Layanan harus berupa angka',
                'service_type_id.*.exists' => 'ID Jenis Layanan tidak ditemukan di database',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        // Proses menyimpan data WorkUnit
        $dataWorkUnit = new WorkUnit();
        $name = $request->name;

        // Buat kode unik dari nama dengan format dishub-provinsi-jawa-timur
        $uniqueCode = Str::slug($name, '-');

        // Simpan hasilnya ke kolom 'code'
        $dataWorkUnit->name = $name;
        $dataWorkUnit->code = $uniqueCode;
        $dataWorkUnit->level = $request->level;
        $dataWorkUnit->province_id = $request->province_id;
        $dataWorkUnit->city_id = $request->city_id;
        $dataWorkUnit->address = $request->address;
        $dataWorkUnit->longitude = $request->longitude;
        $dataWorkUnit->latitude = $request->latitude;
        $dataWorkUnit->email = $request->email;
        $dataWorkUnit->phone_number = $request->phone_number;
        $dataWorkUnit->save();

        // Menyimpan service type ke dalam WorkUnitHasService
        if (is_array($request->service_type_id)) {
            foreach ($request->service_type_id as $serviceTypeId) {
                $workUnitHasService = new WorkUnitHasService();
                $workUnitHasService->work_unit_id = $dataWorkUnit->id;
                $workUnitHasService->service_type_id = $serviceTypeId;
                $workUnitHasService->save();
            }
        }

        // Response sukses
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di Tambah',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [
                "workUnit" => $dataWorkUnit,
                "workUnitHasService" => $workUnitHasService,
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:work_units,id',
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

        $data = WorkUnit::where('id', $request->id)->first();
        $serviceType = ServiceType::all();
        $workUnitHasService = WorkUnitHasService::where('work_unit_id', $data->id)->get();
        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [
                "workUnit" => $data,
                "serviceType" => $serviceType,
                "workUnitHasService" => $workUnitHasService,
            ],

        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function update(Request $request)
    {
        // Validasi request
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'level' => 'required|string|max:255',
                'province_id' => 'required|integer',
                'city_id' => 'required|integer',
                'address' => 'required|string',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'email' => 'required|email|max:255', // Pastikan email unik
                'phone_number' => 'required|digits_between:10,15|numeric',
                'service_type_id' => 'required|array',
                'service_type_id.*' => 'integer|exists:service_types,id',
            ],
            [
                'name.required' => 'Nama Di Perlukan',
                'level.required' => 'Level Di Perlukan',
                'province_id.required' => 'Provinsi Di Perlukan',
                'city_id.required' => 'Kota Di Perlukan',
                'address.required' => 'Alamat Di Perlukan',
                'longitude.numeric' => 'Longitude harus berupa angka',
                'latitude.numeric' => 'Latitude harus berupa angka',
                'email.required' => 'Email Di Perlukan',
                'email.email' => 'Format email tidak valid',
                // 'email.unique' => 'Email sudah digunakan',
                'phone_number.digits_between' => 'Nomor Telepon harus antara 10 sampai 15 digit',
                'phone_number.numeric' => 'Nomor Telepon harus berupa angka',
                'service_type_id.array' => 'Jenis Layanan harus berupa array',
                'service_type_id.*.integer' => 'ID Jenis Layanan harus berupa angka',
                'service_type_id.*.exists' => 'ID Jenis Layanan tidak ditemukan di database',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Cari data WorkUnit berdasarkan ID
        $dataWorkUnit = WorkUnit::find($request->id);
        if (!$dataWorkUnit) {
            return response()->json([
                'status' => false,
                'message' => 'Data WorkUnit tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $name = $request->name;
        $uniqueCode = Str::slug($name, '-');
        $dataWorkUnit->name = $name;
        $dataWorkUnit->code = $uniqueCode;
        $dataWorkUnit->level = $request->level;
        $dataWorkUnit->province_id = $request->province_id;
        $dataWorkUnit->city_id = $request->city_id;
        $dataWorkUnit->address = $request->address;
        $dataWorkUnit->longitude = $request->longitude;
        $dataWorkUnit->latitude = $request->latitude;
        $dataWorkUnit->email = $request->email;
        $dataWorkUnit->phone_number = $request->phone_number;
        $dataWorkUnit->save();

        WorkUnitHasService::where('work_unit_id', $dataWorkUnit->id)->delete();

        if (is_array($request->service_type_id)) {
            foreach ($request->service_type_id as $serviceTypeId) {
                $workUnitHasService = new WorkUnitHasService();
                $workUnitHasService->work_unit_id = $dataWorkUnit->id;
                $workUnitHasService->service_type_id = $serviceTypeId;
                $workUnitHasService->save();
            }
        }

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di Perbarui',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [
                "workUnit" => $dataWorkUnit,
                "workUnitHasService" => $workUnitHasService,
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function destroy(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:work_units,id',
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
        // Cari data WorkUnit berdasarkan ID
        $dataWorkUnit = WorkUnit::find($request->id);
        if (!$dataWorkUnit) {
            return response()->json([
                'status' => false,
                'message' => 'Data WorkUnit tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Hapus semua relasi di tabel WorkUnitHasService
        WorkUnitHasService::where('work_unit_id', $dataWorkUnit->id)->delete();

        // Hapus data WorkUnit
        $dataWorkUnit->delete();

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function disable(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:work_units,id',
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

        $data = WorkUnit::where('id', $request->id)->first();
        $data->is_active = 0;
        $data->save();
        // Response sukses
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil di Nonaktifkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [
                "workUnit" => $data,
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function enable(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:work_units,id',
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

        $data = WorkUnit::where('id', $request->id)->first();
        $data->is_active = 1;
        $data->save();
        // Response sukses
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di aktifkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [
                "workUnit" => $data,
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }

}
