<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Settings\Models\Form;

class  EbpsFormTemplateController extends Controller
{
    public function __construct()
    {

    }

    function index(Request $request)
    {
        $modules = ['Ebps' => 'Ebps'];
        return view('Ebps::form-template.index')->with(compact('modules'));
    }

    function template(Request $request)
    {
        $action = Action::UPDATE;
        $form = Form::find($request->route('id'));
        return view('Settings::form.template')->with(compact('action','form'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        $modules = $this->modules;
        return view('Recommendation::form-template.form')->with(compact('action', 'modules'));
    }

    public function edit(Request $request)
    {
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
