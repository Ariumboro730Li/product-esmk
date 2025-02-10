<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();

        if ($user) {
            $payload['role'] = $user->is_company ? 'company' : 'internal';
        } else {
            $payload = null;
        }

        if (!is_null($payload)) {
            if ($payload['role'] != $role) {
                if ($payload['role'] != 'company') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('company.dashboard');
                }
            }
        }

        $roleModel = null;
        if ($role == 'internal') {
            $roleModel = DB::table('model_has_roles')->where('model_id', $user->id)
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->first();

            if ($roleModel) {
                $roleId = $roleModel->role_id;
                $permissionRole = DB::table('role_has_permissions')
                    ->select('name', 'group', 'guard_name')
                    ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('role_id', $roleId)->get()->toArray();
                $request->permission = $permissionRole;
            }

            $permissionRole = null;
            $roleModel = DB::table('model_has_roles')->where('model_id', $user->id)
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->first();
            if ($roleModel) {
                $roleUserInternal = $roleModel->name;
                $payload['internal_role'] = $roleUserInternal;
            }

            $payload['province_id'] = $user->province_id;
            $payload['city_id'] = $user->city_id;
        }

        $request->user = $user;
        $request->payload = $payload;

        return $next($request);
    }
}
