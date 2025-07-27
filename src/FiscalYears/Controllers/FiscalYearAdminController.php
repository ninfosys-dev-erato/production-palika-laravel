<?php

namespace Src\FiscalYears\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\FiscalYears\Models\FiscalYear;

class FiscalYearAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:fiscal_year access', only: ['index']),
            new Middleware('permission:fiscal_year create', only: ['create']),
            new Middleware('permission:fiscal_year edit', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('FiscalYears::index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FiscalYears::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $fiscalYear = FiscalYear::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FiscalYears::form')->with(compact('action', 'fiscalYear'));
    }
}
