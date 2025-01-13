<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// models
use App\Models\Setting as TblSetting;

class GetSetting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data_setting = TblSetting::where('name','aplikasi')->first();
        $request->app_setting = json_decode(json_encode($data_setting->toArray()));
        return $next($request);
    }
}
