<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EjalasFormAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:local_levels view')->only('index');
        //$this->middleware('permission:local_levels edit')->only('edit');
        //$this->middleware('permission:local_levels create')->only('create');
    }

    function index(Request $request)
    {
        $modules = ['Ejalas' => 'Ejalas'];
        return view('Ejalas::ejalas-form.index', compact('modules'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        $modules = $this->modules;
        return view('Settings::form.form')->with(compact('action', 'modules'));
    }
}
