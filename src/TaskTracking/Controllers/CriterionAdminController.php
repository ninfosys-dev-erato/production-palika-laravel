<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TaskTracking\Models\Criterion;

class CriterionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:criteria view')->only('index');
        //$this->middleware('permission:criteria edit')->only('edit');
        //$this->middleware('permission:criteria create')->only('create');
    }

    function index(Request $request){
        return view('TaskTracking::criteria.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TaskTracking::criteria.form')->with(compact('action'));
    }

    function edit(Request $request){
        $criterion = Criterion::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::criteria.form')->with(compact('action','criterion'));
    }

}
