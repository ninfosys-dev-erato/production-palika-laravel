<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\CustomerFamilyDetail;

class CustomerFamilyDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:customer_family_details view')->only('index');
        //$this->middleware('permission:customer_family_details edit')->only('edit');
        //$this->middleware('permission:customer_family_details create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::family-detail.family-detail-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::family-detail.family-detail-form')->with(compact('action'));
    }

    function edit(Request $request){
        $customerFamilyDetail = CustomerFamilyDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::family-detail.family-detail-form')->with(compact('action','customerFamilyDetail'));
    }

}
