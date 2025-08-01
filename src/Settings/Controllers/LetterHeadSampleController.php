<?php

namespace Src\Settings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Settings\Models\LetterHeadSample;

class LetterHeadSampleController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            // new Middleware('permission:letter_head_sample_access', only: ['index']),
            // new Middleware('permission:letter_head_sample create', only: ['create']),
            // new Middleware('permission:letter_head_sample_update', only: ['edit'])
        ];
    }

    function index(Request $request)
    {
        return view('Settings::letter-head-sample.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Settings::letter-head-sample.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $letterHeadSample = LetterHeadSample::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Settings::letter-head-sample.form')->with(compact('action', 'letterHeadSample'));
    }
}
