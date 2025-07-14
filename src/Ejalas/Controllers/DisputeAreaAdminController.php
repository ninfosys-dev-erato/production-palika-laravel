<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\DisputeArea;

class DisputeAreaAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:dispute_areas view')->only('index');
        //$this->middleware('permission:dispute_areas edit')->only('edit');
        //$this->middleware('permission:dispute_areas create')->only('create');
    }

    function index(Request $request){
        return view('Ejalas::dispute-area.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ejalas::dispute-area.form')->with(compact('action'));
    }

    function edit(Request $request){
        $disputeArea = DisputeArea::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::dispute-area.form')->with(compact('action','disputeArea'));
    }

}
