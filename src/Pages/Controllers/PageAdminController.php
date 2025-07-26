<?php

namespace Src\Pages\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Pages\Models\Page;

class PageAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:page access', only: ['index']),
            new Middleware('permission:page create', only: ['create']),
            new Middleware('permission:page edit', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Pages::index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Pages::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $page = Page::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Pages::form')->with(compact('action', 'page'));
    }
}
