<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\CantileverDetail;

class CantileverDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:cantilever_details view')->only('index');
        //$this->middleware('permission:cantilever_details edit')->only('edit');
        //$this->middleware('permission:cantilever_details create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::cantilever-detail-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::cantilever-detail-form')->with(compact('action'));
    }

    function edit(Request $request){
        $cantileverDetail = CantileverDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::cantilever-detail-form')->with(compact('action','cantileverDetail'));
    }

}
