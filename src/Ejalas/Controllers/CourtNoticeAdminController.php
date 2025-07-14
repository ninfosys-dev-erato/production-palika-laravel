<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\CourtNotice;

class CourtNoticeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:court_notices view')->only('index');
        //$this->middleware('permission:court_notices edit')->only('edit');
        //$this->middleware('permission:court_notices create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::court-notice.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::court-notice.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $courtNotice = CourtNotice::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::court-notice.form')->with(compact('action', 'courtNotice'));
    }
    function preview(Request $request)
    {
        $courtNotice = CourtNotice::findOrFail($request->route('id'));


        return view('Ejalas::court-notice.preview', compact('courtNotice'));
    }
}
