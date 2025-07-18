<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProcessIndicator;

class ProcessIndicatorAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:process_indicators view')->only('index');
        //$this->middleware('permission:process_indicators edit')->only('edit');
        //$this->middleware('permission:process_indicators create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::process-indicators.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::process-indicators.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $processIndicator = ProcessIndicator::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::process-indicators.form')->with(compact('action', 'processIndicator'));
    }
}
