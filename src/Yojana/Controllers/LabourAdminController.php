<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Labour;

class LabourAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:labours view')->only('index');
        //$this->middleware('permission:labours edit')->only('edit');
        //$this->middleware('permission:labours create')->only('create');
    }

    function index(Request $request){
        return view('Labours::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Labours::form')->with(compact('action'));
    }

    function edit(Request $request){
        $labour = Labour::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Labours::form')->with(compact('action','labour'));
    }

}
