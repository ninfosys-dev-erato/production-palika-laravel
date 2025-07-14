<?php

namespace Src\EmergencyContacts\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\EmergencyContacts\Models\EmergencyContact;

class EmergencyContactAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:emergency_contact_access', only: ['index']),
            new Middleware('permission:emergency_contact_create', only: ['create']),
            new Middleware('permission:emergency_contact_update', only: ['edit']),
        ];
    }

    function index(Request $request){
        return view('EmergencyContacts::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('EmergencyContacts::form')->with(compact('action'));
    }

    function edit(Request $request){
        $emergencyContact = EmergencyContact::find($request->route('id'));
        $action = Action::UPDATE;
        return view('EmergencyContacts::form')->with(compact('action','emergencyContact'));
    }

}
