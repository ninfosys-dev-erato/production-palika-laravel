<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Collateral;

class CollateralAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:collaterals view')->only('index');
        //$this->middleware('permission:collaterals edit')->only('edit');
        //$this->middleware('permission:collaterals create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::collaterals.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::collaterals.form')->with(compact('action'));
    }

    function edit(Request $request){
        $collateral = Collateral::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::collaterals.form')->with(compact('action','collateral'));
    }

}
