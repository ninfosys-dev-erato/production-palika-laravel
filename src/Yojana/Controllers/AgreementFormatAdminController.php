<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\AgreementFormat;

class AgreementFormatAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:agreement_formats view')->only('index');
        //$this->middleware('permission:agreement_formats edit')->only('edit');
        //$this->middleware('permission:agreement_formats create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::agreement-formats.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::agreement-formats.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $agreementFormat = AgreementFormat::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::agreement-formats.form')->with(compact('action', 'agreementFormat'));
    }
}
