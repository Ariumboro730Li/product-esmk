<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        $roles = Role::select('name', 'id');

        if ($request->keyword) {
            $roles = $roles->where('name', 'ilike', '%' . $request->keyword . '%');
        }

        $roles = $roles->get();

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $roles,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function getRolebyId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Role::with('permissions')->where('id', $request->id)->first();

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasill diTampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' =>  $data,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function getAndGroupAllPermissions()
    {
        $permissions = Permission::select('id', 'name', 'group')->get();

        $group_permissions = [];
        foreach ($permissions as $permission) {
            $role =[
                "id" => $permission->id,
                "name" => $permission->name
            ];

            $group_permissions[$permission->group][] = $role;

        }
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasill diTampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' =>  $group_permissions,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function syncPermissions(Request $request)
    {
        $role = Role::find($request->id);

        if (!$role) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }

        if (!$request['isAssign']) {
            $role->revokePermissionTo($request['permission']);

            return $role;
        }

        $permissions = Permission::all()->pluck('id')->toArray();
        $validPermissions = array_intersect([$request['permission']], $permissions);

        if (!$validPermissions) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], status: HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $role->givePermissionTo($request['permission']);

        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' =>  $role,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first(),
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $newData = new Role();
        $newData->name = $request->name;
        $newData->is_active = $request->is_active ?? 0;
        $newData->save();

        // Berikan respons sukses
        return response()->json([
            'message' => 'Sukses Membuat Role',
            'status' => true,
            'data' => $newData
        ], HttpStatusCodes::HTTP_CREATED);
    }
}
