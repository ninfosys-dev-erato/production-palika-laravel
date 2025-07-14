<?php

namespace Src\Grievance\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceSetting;

class GrievanceSettingController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:grievance_setting_access', only: ['setting'])
        ];
    }

    public function setting(): Application|Factory|View|\Illuminate\View\View
    {
        $grievanceSetting = GrievanceSetting::latest()->first();
        return view('Grievance::grievanceSetting-index', compact('grievanceSetting'));
    }
}
