<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Signer;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class SignerController extends Controller
{

    public function index(Request $request)
    {

        $dataTable = $this->getDatatable($request);

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $dataTable,
        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function getDatatable($request)
    {
        $query = Signer::where('is_active', 1)->select();

        // Retrieve data without DataTables
        $signers = $query->get();

        // Convert the query result to an array
        $formattedData = $signers->map(function ($signer) {
            return [
                'id' => $signer->id,
                'name' => $signer->name,
            ];
        });

        return $formattedData;
    }
}
