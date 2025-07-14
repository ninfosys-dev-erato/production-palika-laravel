<?php

namespace Src\Settings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Settings\Models\LetterHead;

class LetterHeadController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:letter_head_access', only: ['index']),
            new Middleware('permission:letter_head_create', only: ['create']),
            new Middleware('permission:letter_head_update', only: ['edit'])
        ];
    }

    function index(Request $request)
    {
        return view('Settings::letter-head.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Settings::letter-head.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $letterHead = LetterHead::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Settings::letter-head.form')->with(compact('action', 'letterHead'));
    }
}
