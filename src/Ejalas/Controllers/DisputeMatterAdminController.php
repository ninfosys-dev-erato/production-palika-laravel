<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\DisputeMatter;

class DisputeMatterAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:dispute_matters view')->only('index');
        //$this->middleware('permission:dispute_matters edit')->only('edit');
        //$this->middleware('permission:dispute_matters create')->only('create');
    }

    function index(Request $request){
        return view('Ejalas::dispute-matter.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ejalas::dispute-matter.form')->with(compact('action'));
    }

    function edit(Request $request){
        $disputeMatter = DisputeMatter::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::dispute-matter.form')->with(compact('action','disputeMatter'));
    }

}
