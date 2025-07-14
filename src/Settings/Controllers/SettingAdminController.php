<?php

namespace Src\Settings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\SessionFlash;
use Illuminate\Http\Request;
use Src\Settings\Models\MstSetting;
use Src\Settings\Models\Setting;
use Src\Settings\Models\SettingGroup;

class SettingAdminController extends Controller
{
    use SessionFlash;
    public function __construct()
    {
        //$this->middleware('permission:settings view')->only('index');
        //$this->middleware('permission:settings edit')->only('edit');
        //$this->middleware('permission:settings create')->only('create');
    }

    function index(Request $request){
        return view('Settings::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Settings::form')->with(compact('action'));
    }

    function edit(Request $request){
        $setting = Setting::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Settings::form')->with(compact('action','setting'));
    }

    function manage(string $slug){
        $settingGroup = SettingGroup::where('slug', $slug)->with('settings')->first();
       if($settingGroup){
           return view('Settings::setting-group-settings')->with(compact('settingGroup'));
       }else{

       }
    }

}
