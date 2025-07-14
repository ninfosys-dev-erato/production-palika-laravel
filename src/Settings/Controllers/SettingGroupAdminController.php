<?php

namespace Src\Settings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Settings\Models\SettingGroup;

class SettingGroupAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:setting_groups view')->only('index');
        //$this->middleware('permission:setting_groups edit')->only('edit');
        //$this->middleware('permission:setting_groups create')->only('create');
    }

    function index(Request $request){
        return view('Settings::setting-groups.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Settings::setting-groups.form')->with(compact('action'));
    }

    function edit(Request $request){
        $settingGroup = SettingGroup::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Settings::setting-groups.form')->with(compact('action','settingGroup'));
    }

    function manage(Request $request){
        $settingGroup = SettingGroup::find($request->route('id'));
        $settings = $settingGroup->settings;
        return view('Settings::manage')->with(compact('settingGroup','settings'));
    }

}
