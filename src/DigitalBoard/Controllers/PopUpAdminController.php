<?php

namespace Src\DigitalBoard\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\DigitalBoard\Models\PopUp;

class PopUpAdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:popups_access', only: ['index']),
            new Middleware('permission:popups_create', only: ['create']),
            new Middleware('permission:popups_edit', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('DigitalBoard::popup.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('DigitalBoard::popup.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $popUp = PopUp::find($request->route('id'));
        $action = Action::UPDATE;
        return view('DigitalBoard::popup.form')->with(compact('action', 'popUp'));
    }
}
