<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\LetterSample;

class LetterSampleAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:letter_samples view')->only('index');
        //$this->middleware('permission:letter_samples edit')->only('edit');
        //$this->middleware('permission:letter_samples create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::letter-samples.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::letter-samples.form')->with(compact('action'));
    }

    function edit(Request $request){
        $letterSample = LetterSample::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::letter-samples.form')->with(compact('action','letterSample'));
    }

}
