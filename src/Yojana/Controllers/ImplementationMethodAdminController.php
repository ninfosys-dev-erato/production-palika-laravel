<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ImplementationMethod;

class ImplementationMethodAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:implementation_methods view')->only('index');
        //$this->middleware('permission:implementation_methods edit')->only('edit');
        //$this->middleware('permission:implementation_methods create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::implementation-methods.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::implementation-methods.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $implementationMethod = ImplementationMethod::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::implementation-methods.form')->with(compact('action', 'implementationMethod'));
    }
}
