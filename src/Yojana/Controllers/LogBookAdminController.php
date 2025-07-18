<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\LogBook;
class LogBookAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:log_books view')->only('index');
        //$this->middleware('permission:log_books edit')->only('edit');
        //$this->middleware('permission:log_books create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::log-books.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::log-books.form')->with(compact('action'));
    }

    function edit(Request $request){
        $logBook = LogBook::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::log-books.form')->with(compact('action','logBook'));
    }

}
