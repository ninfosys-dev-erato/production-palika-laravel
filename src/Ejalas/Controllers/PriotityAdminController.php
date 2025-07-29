<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\Priotity;

class PriotityAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:priotities view')->only('index');
        //$this->middleware('permission:priotities edit')->only('edit');
        //$this->middleware('permission:priotities create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::priotity.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::priotity.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $priotity = Priotity::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::priotity.form')->with(compact('action', 'priotity'));
    }
}
