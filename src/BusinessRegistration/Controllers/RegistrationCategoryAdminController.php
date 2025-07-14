<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Facades\FileTrackingFacade;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\RegistrationCategory;

class RegistrationCategoryAdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:registration-category_access', only: ['index']),
            new Middleware('permission:registration-category_create', only: ['create']),
            new Middleware('permission:registration-category_edit', only: ['edit']),
        ];
    }

    public function index(): View
    {
        return view('BusinessRegistration::registration-category.index');
    }

    public function create(): View
    {
        $action = Action::CREATE;
        return view('BusinessRegistration::registration-category.form')->with(compact('action'));
    }

    public function edit(Request $request): View
    {
        $registrationCategory = RegistrationCategory::findOrFail($request->route('id'));
        $action = Action::UPDATE;

        return view('BusinessRegistration::registration-category.form')->with(compact('action', 'registrationCategory'));
    }
    public function register(int $id)
    {
        $business = BusinessRegistration::where('id', $id)->first();
        FileTrackingFacade::recordFile($business, register: $register = true);
        return redirect()->route('admin.business-registration.business-registration.show', $id);
    }
}
