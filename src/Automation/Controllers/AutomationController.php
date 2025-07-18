<?php

namespace Src\Automation\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Models\NatureOfBusiness;

class AutomationController extends Controller
{
 
    public function wardUsers(): View
    {
        return view('Automation::ward-users');
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
