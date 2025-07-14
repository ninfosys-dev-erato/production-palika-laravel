<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\LabourRate;

class LabourRateAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:labour_rates view')->only('index');
        //$this->middleware('permission:labour_rates edit')->only('edit');
        //$this->middleware('permission:labour_rates create')->only('create');
    }

    function index(Request $request){
        return view('LabourRates::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('LabourRates::form')->with(compact('action'));
    }

    function edit(Request $request){
        $labourRate = LabourRate::find($request->route('id'));
        $action = Action::UPDATE;
        return view('LabourRates::form')->with(compact('action','labourRate'));
    }

}
