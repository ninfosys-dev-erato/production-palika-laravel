<?php

namespace Src\LocalBodies\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\LocalBodies\Models\LocalBody;

class LocalBodyAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:local_bodies view')->only('index');
        //$this->middleware('permission:local_bodies edit')->only('edit');
        //$this->middleware('permission:local_bodies create')->only('create');
    }

    function index(Request $request){
        return view('LocalBodies::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('LocalBodies::form')->with(compact('action'));
    }

    function edit(Request $request){
        $localBody = LocalBody::find($request->route('id'));
        $action = Action::UPDATE;
        return view('LocalBodies::form')->with(compact('action','localBody'));
    }

}
