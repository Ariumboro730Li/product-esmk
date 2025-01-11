<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatusCodes;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $service;
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function uploadFile(Request $request)
    {
        // Validasi file
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $fileURL = $this->service->upload($request->file('file'));

        if ($fileURL) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengunggah data',
                'file_url' => $fileURL
            ], HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Gagal mengunggah data'
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
