<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\LetterType;

class LetterTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:letter_types view')->only('index');
        //$this->middleware('permission:letter_types edit')->only('edit');
        //$this->middleware('permission:letter_types create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::letter-types.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::letter-types.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $letterType = LetterType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::letter-types.form')->with(compact('action', 'letterType'));
    }
}
