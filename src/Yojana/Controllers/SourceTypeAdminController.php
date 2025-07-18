<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\SourceType;

class SourceTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:source_types view')->only('index');
        //$this->middleware('permission:source_types edit')->only('edit');
        //$this->middleware('permission:source_types create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::source-types.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::source-types.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $sourceType = SourceType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::source-types.form')->with(compact('action', 'sourceType'));
    }
}
