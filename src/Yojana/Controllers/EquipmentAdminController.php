<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Equipment;

class EquipmentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:equipment view')->only('index');
        //$this->middleware('permission:equipment edit')->only('edit');
        //$this->middleware('permission:equipment create')->only('create');
    }

    function index(Request $request){
        return view('Equipment::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Equipment::form')->with(compact('action'));
    }

    function edit(Request $request){
        $equipment = Equipment::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Equipment::form')->with(compact('action','equipment'));
    }

}
