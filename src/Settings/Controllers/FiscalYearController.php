<?php

namespace Src\Settings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Requests\FiscalYear\StoreFiscalYearRequest;
use Src\Settings\Requests\FiscalYear\UpdateFiscalYearRequest;

class FiscalYearController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:fiscal_year_access', only: ['index']),
            new Middleware('permission:fiscal_year_create', only: ['create']),
            new Middleware('permission:fiscal_year_update', only: ['edit']),
            new Middleware('permission:fiscal_year_delete', only: ['destroy'])
        ];
    }

    public function index(): Application|Factory|View|\Illuminate\View\View
    {
        $fiscalYears = FiscalYear::latest()->get();

        return view('settings::fiscal-year.index', compact('fiscalYears'));
    }

    public function create(): Application|Factory|View|\Illuminate\View\View
    {
        return view('settings::fiscal-year.create');
    }

    public function store(StoreFiscalYearRequest $request): Application|Redirector|RedirectResponse
    {

        FiscalYear::create($request->validated());

        return Redirect(route('admin.fiscalYear.index'));
    }

    public function edit(FiscalYear $fiscalYear): Application|Factory|View|\Illuminate\View\View
    {
        return view('settings::fiscal-year.create', compact('fiscalYear'));
    }


    public function update(UpdateFiscalYearRequest $request, FiscalYear $fiscalYear): Application|Redirector|RedirectResponse
    {

        $fiscalYear->update($request->validated());

        return Redirect(route('admin.fiscalYear.index'));
    }

    public function destroy(FiscalYear $fiscalYear): Application|Redirector|RedirectResponse
    {
        $fiscalYear->delete();
        return Redirect(route('admin.fiscalYear.index'));
    }
}
