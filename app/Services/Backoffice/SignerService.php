<?php

namespace App\Services\Backoffice;
use App\Models\Signer;
use App\Models\WorkUnit;

use DataTables;

use Exception;

class SignerService
{
    private $workUnitID;

    public function __construct($workUnitID = '')
    {
        if ($workUnitID) {
            $this->workUnitID = $workUnitID;
            $this->workUnitDetail = WorkUnit::find($workUnitID);
        }
    }

    public function getDatatable($request)
    {
        $query = Signer::with('workUnit')
            ->select();

        return DataTables::eloquent($query)
            ->toJson();
    }

    public function getDetailByID($id)
    {;
        $data = Signer::select()
        ->findOrfail($id);

        return $data;
    }

    public function store($request)
    {
        $newSigner = new Signer();
        $newSigner->name = $request->name;
        $newSigner->position = $request->position;

        if ($request->identity_type) {
            $newSigner->identity_type = $request->identity_type;
        }

        if ($request->identity_number) {
            $newSigner->identity_number = $request->identity_number;
        }

        return $newSigner->save();

    }

    public function update($id, $request)
    {
        $newSigner = $this->getDetailByID($id);

        $newSigner->name = $request->name;
        $newSigner->position = $request->position;

        if ($request->identity_type) {
            $newSigner->identity_type = $request->identity_type;
        }

        if ($request->identity_number) {
            $newSigner->identity_number = $request->identity_number;
        }

        $newSigner->save();

        return $newSigner;
    }


    public function delete($id)
    {
        $signer = $this->getDetailByID($id);
        $signer->delete();

        return $signer;
    }

}
