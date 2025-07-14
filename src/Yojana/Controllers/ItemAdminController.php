<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Item;

class ItemAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:items view')->only('index');
        //$this->middleware('permission:items edit')->only('edit');
        //$this->middleware('permission:items create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::items.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::items.form')->with(compact('action'));
    }

    function edit(Request $request){
        $item = Item::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::items.form')->with(compact('action','item'));
    }

}
