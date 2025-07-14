<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\FourBoundary;

class FourBoundaryAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:four_boundaries view')->only('index');
        //$this->middleware('permission:four_boundaries edit')->only('edit');
        //$this->middleware('permission:four_boundaries create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::four-boundary.four-boundary-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::four-boundary.four-boundary-form')->with(compact('action'));
    }

    function edit(Request $request){
        $fourBoundary = FourBoundary::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::four-boundary.four-boundary-form')->with(compact('action','fourBoundary'));
    }

}
