<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\SubRegion;

class SubRegionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:sub_regions view')->only('index');
        //$this->middleware('permission:sub_regions edit')->only('edit');
        //$this->middleware('permission:sub_regions create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::sub-regions.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::sub-regions.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $subRegion = SubRegion::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::sub-regions.form')->with(compact('action', 'subRegion'));
    }
}
