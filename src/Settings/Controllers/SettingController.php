<?php

namespace Src\Settings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Settings\Models\MstSetting;

class SettingController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:office_setting_access', only: ['index'])
        ];
    }

    public function index(): Application|Factory|View|\Illuminate\View\View
    {
        return view('Settings::setting-index');
    }
    public function editSetting()
    {
        $logo = MstSetting::where('key', 'palika-logo')->first();
        $palikaCampaginLogo =  MstSetting::where('key', 'palika-campaign-logo')->first();
        return view('Settings::setting-edit', compact('logo', 'palikaCampaginLogo'));
    }
}
