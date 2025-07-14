<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\Storey;

class StoreyAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:storeys view')->only('index');
        //$this->middleware('permission:storeys edit')->only('edit');
        //$this->middleware('permission:storeys create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::storey.storey-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::storey.storey-form')->with(compact('action'));
    }

    function edit(Request $request){
        $storey = Storey::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::storey.storey-form')->with(compact('action','storey'));
    }

}
