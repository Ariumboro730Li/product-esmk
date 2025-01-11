<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\YearlyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaporanTahunanController extends Controller
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
        $meta['limit'] = $request->limit <= 30 ? $request->limit : 30;
        $data = YearlyReport::orderBy('created_at', $meta['orderBy'])->paginate($meta['limit']);
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
}
