<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\NormType;

class NormTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:norm_types view')->only('index');
        //$this->middleware('permission:norm_types edit')->only('edit');
        //$this->middleware('permission:norm_types create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::norm-types.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::norm-types.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $normType = NormType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::norm-types.form')->with(compact('action', 'normType'));
    }
}
