<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\CrewRate;

class CrewRateAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:crew_rates view')->only('index');
        //$this->middleware('permission:crew_rates edit')->only('edit');
        //$this->middleware('permission:crew_rates create')->only('create');
    }

    function index(Request $request){
        return view('CrewRates::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('CrewRates::form')->with(compact('action'));
    }

    function edit(Request $request){
        $crewRate = CrewRate::find($request->route('id'));
        $action = Action::UPDATE;
        return view('CrewRates::form')->with(compact('action','crewRate'));
    }

}
