<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\HelperDate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;

class BerujuDashboardController extends Controller implements HasMiddleware
{
    use HelperDate;
    public static function middleware()
    {
        return [
            new Middleware('permission:beruju access', only: ['index']),
            new Middleware('permission:beruju create', only: ['create']),
            new Middleware('permission:beruju edit', only: ['edit']),
            new Middleware('permission:beruju view', only: ['view', 'preview']),
        ];
    }

    public function index(Request $request)
    {
        return view('Beruju::menu.dashboard');
    }
}
