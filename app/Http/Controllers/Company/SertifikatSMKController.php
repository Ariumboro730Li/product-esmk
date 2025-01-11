<?php

namespace App\Http\Controllers\Company;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\CertificateSmk;
use App\Models\Company;
use App\Models\SmkElement;
use Illuminate\Http\Request;

class SertifikatSMKController extends Controller
{
    public function getSmkCertificate(Request $request)
    {

        $companyId = $this->getModel($request);

        $data = CertificateSmk::where('company_id', $companyId)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        return response()->json([
            'error' => false,
            'message' => 'Data ditemukan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    public function getSmkElement(Request $request)
    {
        $company_id = $this->getModel($request);
        $data = SmkElement::where('is_active', true)->first();
        $companyInfo = Company::with('serviceTypes')->where('id', $company_id)->first();

        
        if (!$data) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_NOT_FOUND,
                'error'         => true,
                'message'       => 'Element keselamatan tidak ditemukan, Silahkan hubungi administrator'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
        $responseData = [
            'title' => $data->title,
            'element_properties' => json_decode($data->element_properties),
            'company_info' => $companyInfo
        ];

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $responseData
        ], HttpStatusCodes::HTTP_OK);
    }
}
