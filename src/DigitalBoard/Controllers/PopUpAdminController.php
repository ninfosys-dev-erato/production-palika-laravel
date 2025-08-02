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
            new Middleware('permission:digital_board access', only: ['index']),
            new Middleware('permission:digital_board create', only: ['create']),
            new Middleware('permission:digital_board edit', only: ['edit']),
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
