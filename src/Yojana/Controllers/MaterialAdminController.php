<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Material;

class MaterialAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:materials view')->only('index');
        //$this->middleware('permission:materials edit')->only('edit');
        //$this->middleware('permission:materials create')->only('create');
    }

    function index(Request $request){
        return view('Materials::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Materials::form')->with(compact('action'));
    }

    function edit(Request $request){
        $material = Material::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Materials::form')->with(compact('action','material'));
    }

}
