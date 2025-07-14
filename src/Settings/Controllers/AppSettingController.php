<?php

namespace Src\Settings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Settings\Models\AppSetting;

class AppSettingController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:app_setting_access', only: ['index'])
        ];
    }

    function index(Request $request)
    {
        $appSetting = AppSetting::latest()->first();
        return view('Settings::app-setting.index', compact('appSetting'));
    }
}
