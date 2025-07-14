<?php

namespace Src\DigitalBoard\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\DigitalBoard\Models\Notice;

class NoticeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:notices view')->only('index');
        //$this->middleware('permission:notices edit')->only('edit');
        //$this->middleware('permission:notices create')->only('create');
    }

    function index(Request $request)
    {
        return view('DigitalBoard::notices.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('DigitalBoard::notices.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $notice = Notice::findOrFail($request->route('id'));
        $action = Action::UPDATE;
        return view('DigitalBoard::notices.form')->with(compact('action', 'notice'));
    }
}
