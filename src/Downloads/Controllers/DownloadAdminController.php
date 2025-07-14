<?php

namespace Src\Downloads\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Downloads\Models\Download;

class DownloadAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:downloads_access', only: ['index']),
            new Middleware('permission:downloads_create', only: ['create']),
            new Middleware('permission:downloads_update', only: ['edit']),
        ];
    }

    function index(Request $request){
        return view('Downloads::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Downloads::form')->with(compact('action'));
    }

    function edit(Request $request){
        $download = Download::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Downloads::form')->with(compact('action','download'));
    }

}
