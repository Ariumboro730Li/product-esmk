<?php

namespace App\Http\Controllers\Company;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\CertificateRequestAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoryPengajuanController extends Controller
{
    public function getRequestHistoryByRequestID(Request $request)
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

        $certificateRequestHistory = $this->getAssessmentHistoryByRequestID($request->id);

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $certificateRequestHistory
        ],  HttpStatusCodes::HTTP_OK);
    }

    public function getAssessmentHistoryByRequestID($id)
    {
        $data = CertificateRequestAssessment::select('id', 'status', 'created_at')
            ->where('certificate_request_id', $id)
            ->where('status', '!=', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        return $data;
    }
}
