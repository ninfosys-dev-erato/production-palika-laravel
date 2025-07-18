<?php

namespace Frontend\BusinessPortal\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\OrganizationUser;

class OrganizationUserAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:organization_users view')->only('index');
        //$this->middleware('permission:organization_users edit')->only('edit');
        //$this->middleware('permission:organization_users create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::organization-user.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::organization-user.form')->with(compact('action'));
    }

    function edit(Request $request){
        $organizationUser = OrganizationUser::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::organization-user.form')->with(compact('action','organizationUser'));
    }

}
