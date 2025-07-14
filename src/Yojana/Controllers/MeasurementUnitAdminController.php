<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\MeasurementUnit;
use Src\Yojana\Models\Type;

class MeasurementUnitAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:measurement_units view')->only('index');
        //$this->middleware('permission:measurement_units edit')->only('edit');
        //$this->middleware('permission:measurement_units create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::measurement-units.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::measurement-units.form')->with(compact('action', ));
    }

    function edit(Request $request){
        $measurementUnit = MeasurementUnit::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::measurement-units.form')->with(compact('action','measurementUnit'));
    }

}
