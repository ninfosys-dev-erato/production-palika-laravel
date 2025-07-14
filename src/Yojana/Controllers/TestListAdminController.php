<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\TestList;

class TestListAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:test_lists view')->only('index');
        //$this->middleware('permission:test_lists edit')->only('edit');
        //$this->middleware('permission:test_lists create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::test-lists.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::test-lists.form')->with(compact('action'));
    }

    function edit(Request $request){
        $testList = TestList::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::test-lists.form')->with(compact('action','testList'));
    }

}
