<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getModel(Request $request) {
        $user = auth()->user();
        $role = $user->is_company ? 'company' : 'internal';
        if ($role != 'company') {
            return auth()->user()->id;
        } else {
            $company = DB::table('companies')->where('user_id', auth()->user()->id)->first();
            return $company->id;
        }
    }
}
