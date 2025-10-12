<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\FormType;

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
     function formTypeIndex(Request $request){
        return view ('Ejalas::ejalas-form.form-type-index');
    }

    function formTypeCreate(Request $request){
        $action = Action::CREATE;
        return view ('Ejalas::ejalas-form.form-type-form')->with(compact('action'));
    }
    function formTypeEdit(Request $request){
        $action = Action::UPDATE;
        $formType = FormType::find($request->route('id'));
        return view ('Ejalas::ejalas-form.form-type-form')->with(compact('action', 'formType'));
    }
}
