<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Http\Controllers\Controller;
use App\Traits\HelperTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\Plan;

class PlanAdminController extends Controller
{
    use AdminSettings, HelperTemplate;
    public function __construct()
    {
        //$this->middleware('permission:plans view')->only('index');
        //$this->middleware('permission:plans edit')->only('edit');
        //$this->middleware('permission:plans create')->only('create');
    }

    function index(Request $request)
    {
        $category = 'plan';
        return view('Yojana::plans.index')->with(compact('category'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        $category = 'plan';
        return view('Yojana::plans.form')->with(compact('action','category'));
    }

    function edit(Request $request)
    {
        $plan = Plan::find($request->route('id'));
        $action = Action::UPDATE;
        $category = 'plan';

        return view('Yojana::plans.form')->with(compact('action', 'plan','category'));
    }

    function show(Request $request)
    {
        $plan = Plan::with([
            'budgetSources.sourceType',
            'budgetSources.budgetDetail',
            'budgetSources.budgetHead',
            'budgetSources.expenseHead',
            'budgetSources.fiscalYear',
            'ward'
        ])->find($request->route('id'));
        $category = 'plan';
        return view('Yojana::plans.show')->with(compact('plan','category'));
    }

    public function costEstimationPrint($id)
    {
        $plan = Plan::with(['costEstimation.costEstimationDetail', 'costEstimation.costDetails', 'costEstimation.configDetails'])->find($id);
        $costEstimation = $plan->costEstimation;
        return view('Yojana::cost-estimation.print')->with(compact('costEstimation'));
    }

    public function downloadPdf($id)
    {
        $plan = Plan::with(['costEstimation.costEstimationDetail', 'costEstimation.costDetails', 'costEstimation.configDetails'])->find($id);
        $costEstimation = $plan->costEstimation;

        if (!$plan || !$plan->costEstimation) {
            abort(404, 'Plan or cost estimation not found.');
        }

        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
//        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));


        $html = view('Yojana::cost-estimation.print', compact('costEstimation',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.Yojana.yojana.cost-estimation'),
            file_name: "token_{$user->email}" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }

    public function print(Request $request)
    {
        $plan = Plan::with([
            'budgetSources.sourceType',
            'budgetSources.budgetDetail',
            'budgetSources.budgetHead',
            'budgetSources.expenseHead',
            'budgetSources.fiscalYear',
            'ward'
        ])->find($request->route('id'));
        $category = 'plan';

        $date = replaceNumbers(ne_date(date('Y-m-d')),true);

        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $header = $this->getLetterHeader($ward,$date);


        $html = view('Yojana::plans.print', compact(  'plan','header'))->render();

        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.Yojana.yojana.plan'),
            file_name: "token_{$user->email}" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }

}
