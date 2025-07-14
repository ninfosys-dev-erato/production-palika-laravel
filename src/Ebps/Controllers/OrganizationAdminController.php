<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\Organization;

class OrganizationAdminController extends Controller
{
    public function __construct()
    {
        
    }

    function index(Request $request){
        return view('Ebps::organization.organization-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::organization.organization-form')->with(compact('action'));
    }

    function edit(Request $request){
        $organization = Organization::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::organization.organization-form')->with(compact('action','organization'));
    }

    public function show(int $id)
    {
        $organization = Organization::with([
            'province',
            'district',
            'localBody',
            'taxClearances',
            'user'
        ])
        ->findOrFail($id);
        return view('Ebps::organization.organization-show', compact('organization'));
    }


    public function deactivate(int $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->is_active = !$organization->is_active;
        $organization->save();

        return redirect()->route('admin.ebps.organizations.show', $organization->id);

    }

}
