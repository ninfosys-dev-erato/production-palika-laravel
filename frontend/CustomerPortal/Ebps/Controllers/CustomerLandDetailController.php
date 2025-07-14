<?php

namespace Frontend\CustomerPortal\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\CustomerLandDetail;

class CustomerLandDetailController extends Controller
{
    function index(Request $request){
        // return view('CustomerPortal.CustomerKyc::customerKyc-show')->with(compact( 'customer'));
        return view('CustomerPortal.Ebps::land-detail-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('CustomerPortal.Ebps::land-detail-form')->with(compact('action'));
    }

    function edit(Request $request){
        $customerLandDetail = CustomerLandDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('CustomerPortal.Ebps::land-detail-form')->with(compact('action','customerLandDetail'));
    }

}
