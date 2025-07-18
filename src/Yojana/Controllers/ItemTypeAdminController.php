<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ItemType;

class ItemTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:item_types view')->only('index');
        //$this->middleware('permission:item_types edit')->only('edit');
        //$this->middleware('permission:item_types create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::item-types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::item-types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $itemType = ItemType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::item-types.form')->with(compact('action','itemType'));
    }

}
