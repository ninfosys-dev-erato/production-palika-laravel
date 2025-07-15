<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Models\NatureOfBusiness;

class BusinessNatureAdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:business_natures create', only: ['create']),
            new Middleware('permission:business_natures edit', only: ['edit'])
        ];
    }

    public function index(): View
    {
        return view('BusinessRegistration::business-nature.index');
    }


    public function create(): View
    {
        $action = Action::CREATE;

        return view('BusinessRegistration::business-nature.form')->with(compact('action'));
    }

    public function edit(Request $request)
    {
        $businessNature = NatureOfBusiness::findOrFail($request->route('id'));
        $action = Action::UPDATE;

        return view('BusinessRegistration::business-nature.form')->with(compact('action', 'businessNature'));
    }
}
