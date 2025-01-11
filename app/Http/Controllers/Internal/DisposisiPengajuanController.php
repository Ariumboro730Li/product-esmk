<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisposisiPengajuanController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:certificate_request_assessments,id',
            'assessor' => 'required|exists:users,id',
        ], [
            'id.required' => 'ID Di Perlukan',
            'id.exists' => 'ID Tidak Di Temukan',
            'assessor.required' => 'Penilai tidak boleh kosong',
            'assessor.exists' => 'Penilai tidak ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $newAssessor = $this->updateAssessor($request);

        if ($newAssessor) {
            return response()->json([
                'error' => false,
                'message' => 'Berhasil mengubah penilai',
                'status_code' => HttpStatusCodes::HTTP_OK,
            ], HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengubah penilai',
                'status_code' => HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR,
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateAssessor(Request $request)
    {
        $newAssessor = CertificateRequest::where('id', $request->id)->first();
        $userId =  $this->getModel($request);
        $newAssessor->disposition_by = $userId;
        $newAssessor->disposition_to = $request->assessor;

        if (!empty($request->status)) {
            $newAssessor->status = $request->status;
        }

        $newAssessor->save();

        return $newAssessor;
    }
}
