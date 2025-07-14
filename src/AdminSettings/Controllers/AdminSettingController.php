<?php

namespace Src\AdminSettings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\Action;
use Src\AdminSettings\Models\AdminSetting;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminSettingController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:setting_access', only: ['index']),
            new Middleware('permission:setting_create', only: ['create']),
            new Middleware('permission:setting_update', only: ['edit']),
        ];
    }

    public function index()
    {
        return view('AdminSettings::setting.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('AdminSettings::setting.create')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $setting = AdminSetting::find($request->route('id'));
        $action = Action::UPDATE;
        return view('AdminSettings::setting.create')->with(compact('action', 'setting'));
    }
}
