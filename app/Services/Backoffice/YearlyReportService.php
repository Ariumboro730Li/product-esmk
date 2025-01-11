<?php

namespace App\Services\Backoffice;
use App\Models\YearlyReport;
use App\Models\YearlyReportLog;
use App\Models\Company;

use App\Models\WorkUnit;
use App\Models\WorkUnitHasService;

use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class YearlyReportService
{
    public function __construct($workUnit = [])
    {
        if (!empty($workUnit)) {
            $this->userWorkUnit = $workUnit;
            $this->workUnitDetail = WorkUnit::find($workUnit);
            $this->coverageService = WorkUnitHasService::select()
                ->get()
                ->pluck('service_type_id')
                ->toArray();
        }
    }

    public function getDatatable($request, $company_id=false)
    {
        $data = YearlyReport::with([
            'assessor',
            'company'
        ])
        ->select('yearly_reports.*')
        ->where('yearly_reports.is_active', true);

        if ($company_id) {
            $data = $data->where('yearly_reports.company_id', $company_id);
        }
        return DataTables::eloquent($data)
            ->toJson();
    }

    public function getDetailByID($requestID)
    {
        $data = YearlyReport::with([
                'company.serviceTypes',
                'company.province',
                'company.city',
                'company'
            ])
            ->join('monitoring_elements', 'monitoring_element_id', 'monitoring_elements.id')
            ->select(
                'yearly_reports.*',
                'assessor',
                'monitoring_elements.element_properties as element_properties',
                'monitoring_elements.monitoring_elements as monitoring_elements',
                'monitoring_elements.additional_questions as additional_questions',
                'assessments',
                'answers',
                'approved_at',
                'yearly_reports.created_at as created_at'
            )
            ->where('yearly_reports.id', $requestID)
            ->first();

        return $data;
    }

    public function getDetail($id)
    {
        $filterProvince = $this->workUnitDetail->province_id;
        $filterCity = $this->workUnitDetail->city_id;

        $data = YearlyReport::with(['company'])
        ->select()
        ->where('id', $id)
        ->whereHas('company', function($subQuery) use ($filterProvince, $filterCity) {
            if ($this->workUnitDetail->level === 'Level 2') {
                return $subQuery->where('province_id', $filterProvince);
            }

            if ($this->workUnitDetail->level === 'Level 3') {
                return $subQuery->where('city', $filterCity);
            }
        })
        ->firstOrFail();

        return $data;
    }

    public function updateAssessment($id, $request)
    {
        $oldData = $this->getDetail($id);
        $oldData->status = $request->assessment_status;
        $oldData->assessments = $request->assessments;
        $oldData->assessor = $request->assessor;
        $oldData->approved_at = $request['approved_at'];
        $oldData->save();

        return $oldData;
    }

    function updateYearlyRerport()
    {
        try {
            DB::beginTransaction();

            $yearlyReport = $this->updateAssessment($id, $request);

            if ($request['assessment_status'] === 'verified') {

                $oldYearlyReportLog = $this->updateYearlyReportYearLog($yearlyReport->company_id, $yearlyReport->year);

                $request['next_year'] = Carbon::parse($oldYearlyReportLog->due_date)->addYears(1)->format('Y');
                $request['next_due_date'] = Carbon::parse($oldYearlyReportLog->due_date)->addYears(1)->format('Y-m-d');

                $this->storeYearlyReportLog($yearlyReport->company_id, $request);
            }
            DB::commit();

            return $yearlyReport;
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function getCompanyForYearlyReminder() {
        $data = Company::select('companies.id', 'companies.name', 'companies.email', 'companies.username', 'companies.nib', 'companies.address', 'companies.pic_name', 'certificate_smks.publish_date', 'certificate_smks.is_active')
        ->join('certificate_smks','companies.id','certificate_smks.company_id')
        ->where('certificate_smks.is_active', true)
        ->get();
        return $data;
    }


    public function getReportYearLogByYearCompanyIDandYear($companyID, $year)
    {
        $yearlyReport = YearlyReportLog::select()
        ->where('company_id', $companyID)
        ->where('year', $year)
        ->firstOrFail();

        return $yearlyReport;
    }

    public function updateYearlyReportYearLog($companyID, $year, $yearlyReportID)
    {
        $newdata = $this->getReportYearLogByYearCompanyIDandYear($companyID, $year);
        $newdata->is_completed = true;
        $newData->yearly_report_id = $yearlyReportID;
        $newData->save();
    }

    public function storeYearlyReportLog($companyID, $request)
    {
        $newData = new YearlyReportLog();
        $newData->company_id = $companyID;
        $newData->year = $request->next_year;
        $newData->due_date = $request->next_due_date;
        $newData->save();
    }


}
