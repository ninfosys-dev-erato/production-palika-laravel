<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\TargetEntry;

class TargetEntryAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:plan view')->only('index');
        //$this->middleware('permission:plan edit')->only('edit');
        //$this->middleware('permission:plan create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::target-entry.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::target-entry.form')->with(compact('action'));
    }

    function edit(Request $request){
        $targetEntry = TargetEntry::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::target-entry.form')->with(compact('action','targetEntry'));
    }

}
