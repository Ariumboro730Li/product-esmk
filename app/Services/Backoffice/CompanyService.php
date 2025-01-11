<?php

namespace App\Services\Backoffice;

use App\Models\Company;
use App\Models\User as TblUser;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Exception;

use App\Models\WorkUnit;
use App\Models\WorkUnitHasService;


class CompanyService
{
    public function getDatatable($request)
    {
        if ($request->searchByServiceType != null) {
            $filterService = $request->searchByServiceType;
        }

        $companiesQuery = Company::with([
                'city',
                'province',
                'serviceTypes'
            ])
            ->whereHas('serviceTypes', function($subQuery) use ($filterService) {
                $subQuery->wherein('service_type_id', $filterService);
            })
            ->leftJoin('certificate_requests', function($query) {
                $query->on('certificate_requests.company_id', 'companies.id')
                    ->where('certificate_requests.is_active', true);
            })
            ->select('companies.*', 'certificate_requests.status as certificate_request_status');

        if($request->searchByProvince != null) {
            $companiesQuery->where('companies.province_id','=',$request->searchByProvince);
        }

        if (isset($request->searchByCertificateStatus)) {
            if ($request->searchByCertificateStatus == 0) {
                $companiesQuery = $companiesQuery->whereNull('certificate_requests.status');
            }

            if ($request->searchByCertificateStatus == 1) {
                $companiesQuery = $companiesQuery->where('certificate_requests.status', 'certificate_validation');
            }

            if ($request->searchByCertificateStatus == 2) {
                $onProgress = [
                    'request',
                    'disposition',
                    'not_passed_assessment',
                    'submission_revision',
                    'passed_assessment',
                    'not_passed_assessment_verification',
                    'passed_assessment_verification',
                    'scheduling_interview',
                    'scheduled_interview',
                    'completed_interview',
                    'verification_director'
                ];
                $companiesQuery = $companiesQuery->whereIn('certificate_requests.status', $onProgress);
            }

            if ($request->searchByCertificateStatus == 3) {
                $companiesQuery = $companiesQuery->where('certificate_requests.status', 'expired');
            }
        }

        return DataTables::eloquent($companiesQuery)
            ->toJson();
    }

    public function create($request)
    {
        $data = $this->getCleanData($request);

        $new_role = Role::create($data);

        return $new_role;
    }

    public function getDetailByID($id)
    {
        $company = Company::with(
            [
                'city',
                'province',
                'serviceTypes'
            ]
        )
        ->where('id', $id)
        ->whereHas('serviceTypes', function($subQuery) {
            $subQuery->wherein('service_type_id', $this->coverageService);
        });

        if ($this->workUnitDetail->level === 'Level 2') {
            $company = $company->where('province_id', $this->workUnitDetail->province_id);
        }

        if ($this->workUnitDetail->level === 'Level 3') {
            $company = $company->where('city_id', $this->workUnitDetail->city_id);
        }

        $company = $company->firstOrFail();

        return $company;
    }

    public function getAccountRequests($request)
    {
        $companiesQuery = Company::with(['city', 'province', 'serviceTypes'])
            ->whereNull('approved_by')
            ->select('companies.*');

        return DataTables::eloquent($companiesQuery)
            ->toJson();
    }

    public function approveAccountRequest($id, $request)
    {
        $company = $this->getDetailByID($id);
        $company->approved_by = $request['approved_by'];
        $company->approved_at = $request['approved_at'];
        $company->password = Hash::make('esmk2023');
        $company->is_active = true;
        $company->save();

        return $company;
    }

    public function update($id, $request)
    {
        try {
            $data = $this->getCleanData($request);
        } catch (Exception $e) {
            throw $e;
        }

        return $role;
    }

    public function delete($id)
    {

        $oldData = $this->getDetailByID($id);
        $oldData = $oldData->delete();

        return $oldData;
    }

    public function find($id)
    {
        //
    }

    public function findByEmail($email) {
        return TblUser::where('email','=',$email)->first();
    }

    public function updatePasswordByEmail($email, $password) {
        $find = TblUser::where('email','=',$email)->first();
        if($find) {
            $find->password = Hash::make($password);
            $find->save();
            return true;
        }
        return false;
    }

    public function all($order = null)
    {
        //
    }

    public function getUserRoles($user)
    {
        //
    }

    protected function getCleanData($request)
    {
        return $request->only(['name', 'is_active']);
    }
}
