<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Beruju\Models\SubCategory;

class SubCategoryAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:sub-categories view')->only('index');
        //$this->middleware('permission:sub-categories edit')->only('edit');
        //$this->middleware('permission:sub-categories create')->only('create');
    }

    function index(Request $request)
    {
        return view('Beruju::sub-categories.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Beruju::sub-categories.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $subCategory = SubCategory::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Beruju::sub-categories.form')->with(compact('action', 'subCategory'));
    }
}
