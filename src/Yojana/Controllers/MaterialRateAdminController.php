<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\MaterialRate;

class MaterialRateAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:material_rates view')->only('index');
        //$this->middleware('permission:material_rates edit')->only('edit');
        //$this->middleware('permission:material_rates create')->only('create');
    }

    function index(Request $request){
        return view('MaterialRates::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('MaterialRates::form')->with(compact('action'));
    }

    function edit(Request $request){
        $materialRate = MaterialRate::find($request->route('id'));
        $action = Action::UPDATE;
        return view('MaterialRates::form')->with(compact('action','materialRate'));
    }

}
