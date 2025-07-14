<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Activity;

class ReportAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:activities view')->only('index');
        //$this->middleware('permission:activities edit')->only('edit');
        //$this->middleware('permission:activities create')->only('create');
    }


    function agreedPlans(Request $request)
    {
        return view('Yojana::reports.agreed-plans');
    }
    function extendedPlans(Request $request)
    {
        return view('Yojana::reports.extended-plans');
    }
    function closedPlans(Request $request)
    {
        return view('Yojana::reports.closed-plans');
    }
    function planReport()
    {
        return view('Yojana::reports.plan-report');
    }
    public function programReport()
    {
        return view('Yojana::reports.program-report');
    }
    function paymentReport()
    {
        return view('Yojana::reports.plan-report');
    }

    public function plansByAllocatedBudget()
    {
        return view('Yojana::reports.plans-by-allocated-budget');
    }

    public function planGoalsReport()
    {
        return view('Yojana::reports.plan-goals-report');
    }

    public function costEstimationByArea()
    {
        return view('Yojana::reports.cost-estimation-by-area');
    }
    public function planByCompletion()
    {
        return view('Yojana::reports.plan-by-completion');
    }

    public function costEstimationByBudgetSource()
    {
        return view('Yojana::reports.cost-estimation-by-budget-source');
    }

    public function costEstimationByDepartment()
    {
        return view('Yojana::reports.cost-estimation-by-department');
    }

    public function costEstimationByExpenseHead()
    {
        return  view('Yojana::reports.cost-estimation-by-expense-head');
    }
    public function activePlan()
    {
        return view('Yojana::reports.active-plan');
    }

    public function taxDeductionReport()
    {
        return view('Yojana::reports.tax-deduction-report');
    }

    public function wardPlansByArea()
    {
        return view('Yojana::reports.ward-plan-by-area');
    }

    public function plansByConsumerCommittee()
    {
        return view('Yojana::reports.plan-by-consumer-committee');
    }
    public function overDuePlanReport()
    {
        return view('Yojana::reports.overdue-plan-report');
    }

    public function wardPlansByBudget()
    {
        return view('Yojana::reports.ward-plan-by-budget');
    }

    public function paidPlans()
    {
        return view('Yojana::reports.paid-plan');
    }

    public function wardPlansByDepartment()
    {
        return view('Yojana::reports.ward-plan-by-department');
    }

    public function MunicipalityPlansByBudget()
    {
        return view('Yojana::reports.municipality-plan-by-budget');
    }

    public function plansByOrganization()
    {
        return view('Yojana::reports.plan-by-organization');
    }

    public function planNearDeadline()
    {
        return view('Yojana::reports.plan-near-deadline');
    }

}
