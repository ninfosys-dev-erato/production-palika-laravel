<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Application;

class ApplicationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:applications view')->only('index');
        //$this->middleware('permission:applications edit')->only('edit');
        //$this->middleware('permission:applications create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::applications.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::applications.form')->with(compact('action'));
    }

    function edit(Request $request){
        $application = Application::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::applications.form')->with(compact('action','application'));
    }

}
