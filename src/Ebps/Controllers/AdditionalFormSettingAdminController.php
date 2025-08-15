<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\AdditionalForm;

class AdditionalFormSettingAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:additional_form_settings view')->only('index');
        //$this->middleware('permission:additional_form_settings edit')->only('edit');
        //$this->middleware('permission:additional_form_settings create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ebps::additional-form-setting.additional-form-setting-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ebps::additional-form-setting.additional-form-setting-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $additionalForm = AdditionalForm::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::additional-form-setting.additional-form-setting-form')->with(compact('action', 'additionalForm'));
    }
}
