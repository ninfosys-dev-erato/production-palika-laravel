<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\GrantProgram;

class GrantProgramAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:grant_programs view')->only('index');
        //$this->middleware('permission:grant_programs edit')->only('edit');
        //$this->middleware('permission:grant_programs create')->only('create');
    }

    function index(Request $request)
    {
        return view('GrantManagement::grant-programs.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::grant-programs.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $grantProgram = GrantProgram::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::grant-programs.form')->with(compact('action', 'grantProgram'));
    }

    // function show(Request $request)
    // {
    //     $grantProgram = GrantProgram::find($request->route('id'));
    //     return view('GrantManagement::grant-programs.show')->with(compact('grantProgram'));
    // }

    function show(Request $request)
    {
        $grantProgram = GrantProgram::with(['fiscalYear', 'grantType', 'grantingOrganization'])->find($request->route('id'));
        if(!$grantProgram){
            $grantProgram = [];
        }
        return view('GrantManagement::grant-programs.show')->with(compact('grantProgram'));

    }

    function reports()
    {
        $action = Action::CREATE;
        return view('GrantManagement::grant-program-reports.form')->with(compact('action'));
    }
}
