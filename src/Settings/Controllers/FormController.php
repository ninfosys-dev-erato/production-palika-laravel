<?php

namespace Src\Settings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Settings\Models\Form;

class  FormController extends Controller implements HasMiddleware
{
    public $modules  = [];
    public function __construct()
    {
        $this->modules = [
            'Recommendation' => 'Recommendation',
            'Business Registration' => 'business-registration',
            'Plan Management System' => 'plan_management_system',
            'Ebps' => 'Ebps',
            'Patrachar' => 'Patrachar',
            'Ejalas' => 'Ejalas'
        ];
    }

    public static function middleware()
    {
        return [
            new Middleware('permission:form access', only: ['index']),
            new Middleware('permission:form create', only: ['create']),
            new Middleware('permission:form edit', only: ['edit'])
        ];
    }

    function index(Request $request)
    {
        $modules = $this->modules;
        return view('Settings::form.index')->with(compact('modules'));
    }

    function template(Request $request)
    {
        $action = Action::UPDATE;
        $modules = $this->modules;
        $form = Form::find($request->route('id'));
        return view('Settings::form.template')->with(compact('action', 'form', 'modules'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        $modules = $this->modules;
        return view('Settings::form.form')->with(compact('action', 'modules'));
    }

    public function edit(Request $request)
    {
        //        dd('here');
        $modelForm = Form::find($request->route('id'));
        $form = [
            'id' => $modelForm->id,
            'title' => $modelForm->title,
            'module' => $modelForm->module->value,
        ];
        array_push($form, json_decode($modelForm->fields, true, 512));
        $action = Action::UPDATE;
        $modules = $this->modules;
        return view('Settings::form.form', compact('action', 'form', 'modules'));
    }
}
