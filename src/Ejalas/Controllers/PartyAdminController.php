<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\Party;

class PartyAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:parties view')->only('index');
        //$this->middleware('permission:parties edit')->only('edit');
        //$this->middleware('permission:parties create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::party.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::party.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $party = Party::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::party.form')->with(compact('action', 'party'));
    }
}
