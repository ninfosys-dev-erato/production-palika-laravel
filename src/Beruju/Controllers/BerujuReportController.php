<?php

namespace Src\Beruju\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BerujuReportController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:beruju access', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        return view('Beruju::reports.beruju-report');
    }
}
