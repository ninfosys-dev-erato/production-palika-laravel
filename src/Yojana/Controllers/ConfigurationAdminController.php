<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Configuration;

class ConfigurationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:configurations view')->only('index');
        //$this->middleware('permission:configurations edit')->only('edit');
        //$this->middleware('permission:configurations create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::configurations.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::configurations.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $configuration = Configuration::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::configurations.form')->with(compact('action', 'configuration'));
    }
}
