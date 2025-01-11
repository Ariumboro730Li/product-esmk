<?php

namespace App\Services\Backoffice;

use App\Models\Company;
use App\Models\CertificateRequest;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\WorkUnit;
use App\Models\WorkUnitHasService;
use Illuminate\Support\Facades\Auth;
use App\Models\YearlyReportLog;
use DataTables;
use Carbon\Carbon;


class DashboardService
{
    public function company()
    {
        $queryCompany = Company::with('serviceTypes');
        $queryCompany->whereBetween('created_at',[$this->dateFrom, $this->dateTo]);

        return $queryCompany->get();
    }

    public function certificateRequest()
    {

        $queryCertificateRequest = CertificateRequest::with('company')
        ->whereBetween('certificate_requests.created_at',[$this->dateFrom, $this->dateTo])
        ->where('certificate_requests.status', '!=', 'draft')
        ->get();

        return $queryCertificateRequest;

    }

    public function serviceType()
    {
        $dateFrom   = $this->dateFrom;
        $dateTo     = $this->dateTo;

        $query =  ServiceType::with([
            'companies' => function($subQuery) use ($dateFrom, $dateTo) {
                return $subQuery->whereBetween('companies.created_at',[$dateFrom, $dateTo]);
            }
        ])
        ->select()
        ->orderBy('service_types.name', 'asc')
        ->get();

        return $query;
    }

    public function userAssessor()
    {
        $dateFrom   = $this->dateFrom;
        $dateTo     = $this->dateTo;
        $queryUser = User::select(
                        "name",
                    )
                    ->with("workUnit")
                    ->withCount([
                        'certificate_request_disposisition' => function($query) use($dateFrom, $dateTo) {
                            return $query->whereBetween('created_at',[$dateFrom, $dateTo]);
                        },
                        'certificate_request_disposition_process' => function($query) use($dateFrom, $dateTo) {
                            return $query->whereBetween('created_at',[$dateFrom, $dateTo]);
                        },
                        'certificate_request_completed' => function($query) use($dateFrom, $dateTo) {
                            return $query->whereBetween('created_at',[$dateFrom, $dateTo]);
                        }
                    ])
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Assessor');
                    });
        return DataTables::eloquent($queryUser)
            ->toJson();
    }

    public function yearlyReport()
    {
        $filterProvince = $this->workUnitDetail->province_id;
        $filterCity = $this->workUnitDetail->city_id;
        $currentDate = Carbon::now()->subMonths(1)->format('Y-m-d');

        $yearlyReport = YearlyReportLog::with('company')
        ->whereHas('company.serviceTypes', function($subQuery) {
            $subQuery->wherein('service_type_id', $this->coverageService);
        })
        ->whereHas('company', function($subQuery) use ($filterProvince, $filterCity) {
            if ($this->workUnitDetail->level === 'Level 2') {
                return $subQuery->where('province_id', $filterProvince);
            }

            if ($this->workUnitDetail->level === 'Level 3') {
                return $subQuery->where('city', $filterCity);
            }
        })
        ->whereDate('due_date', '<', $currentDate)
        ->where('is_completed', false)
        ->get();

        return $yearlyReport;
    }
}
