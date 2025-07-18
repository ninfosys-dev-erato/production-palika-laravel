<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Settings\Traits\AdminSettings;
use Src\Wards\Models\Ward;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\Plan;

class ProgramAdminController extends Controller
{
    use AdminSettings;
    public function __construct()
    {
        //$this->middleware('permission:plans view')->only('index');
        //$this->middleware('permission:plans edit')->only('edit');
        //$this->middleware('permission:plans create')->only('create');
    }

    function index(Request $request)
    {
        $category = 'program';
        return view('Yojana::plans.index')->with(compact('category'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        $category = 'program';
        return view('Yojana::plans.form')->with(compact('action','category'));
    }

    function edit(Request $request)
    {
        $plan = Plan::find($request->route('id'));
        $action = Action::UPDATE;
        $category = 'program';

        return view('Yojana::plans.form')->with(compact('action', 'plan','category'));
    }

    function show(Request $request)
    {
        $plan = Plan::with([
            'budgetSources.sourceType',
            'budgetSources.budgetDetail',
            'budgetSources.budgetHead',
            'budgetSources.expenseHead',
            'budgetSources.fiscalYear'
        ])->find($request->route('id'));

        $category = 'program';
        return view('Yojana::plans.show')->with(compact('plan', 'category'));
    }


}
