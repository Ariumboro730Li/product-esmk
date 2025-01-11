<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use App\Models\CertificateRequestAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenilaianPengajuanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'answers' => 'required',
            'assessments' => 'required'
        ], [
            'answers.required' => 'Jawaban tidak boleh kosong',
            'assessments.required' => 'Nilai tidak boleh kosong'
        ]);

        // Jika validasi gagal, kembalikan response dengan error
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Panggil fungsi untuk menyimpan data
        $data = $this->storeRequest($request);

        // Kembalikan response sesuai hasil simpan data
        if ($data) {
            return response()->json([
                'error' => false,
                'message' => 'Berhasil memberikan penilaian',
                'status_code' => HttpStatusCodes::HTTP_OK,
            ], HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Gagal menyimpan data',
                'status_code' => HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR,
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeRequest(Request $request)
    {
        $userId = $this->getModel($request);
        // Ambil data yang sudah ada
        $data = CertificateRequestAssessment::where('certificate_request_id', $request->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        // Jika data tidak ditemukan, kembalikan pesan error
        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => "Pengajuan tidak ditemukan",
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Buat data baru berdasarkan request
        $newData = new CertificateRequestAssessment();
        $newData->certificate_request_id = $request->id;
        $newData->element_properties = json_encode($request->element_properties); // Tidak perlu true di json_encode
        $newData->answers = json_encode($request->answers);
        $newData->status = $request->status;

        // Cek dan assign assessor jika ada
        if ($request->has('assessor')) {
            $newData->assessor = $userId;
        }

        // Cek dan assign assessments jika ada
        if ($request->has('assessments')) {
            $newData->assessments = json_encode($request->assessments);
        }

        // Cek dan assign validation notes jika ada
        if ($request->has('validation_notes')) {
            $newData->validation_notes = $request->validation_notes;
        }

        // Cek dan assign rejected note jika ada
        if ($request->has('rejected_note')) {
            $newData->rejected_note = $request->rejected_note;
        }

        $newData->save();

        // Update data lama (bila ada)
        $oldData = $this->getCertificateRequestByID($request->id);
        if ($oldData) {
            $oldData->status = $request->status;
            $oldData->save();
        }

        return $newData;
    }

    public function getCertificateRequestByID($id)
    {
        $data = CertificateRequest::select()
            ->where('id', $id)
            ->firstOrFail();

        return $data;
    }
}
