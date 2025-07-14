<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Activity;

class ActivityAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:activities view')->only('index');
        //$this->middleware('permission:activities edit')->only('edit');
        //$this->middleware('permission:activities create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::activities.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::activities.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $activity = Activity::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::activities.form')->with(compact('action', 'activity'));
    }
}
