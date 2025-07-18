<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\Cooperative;

class CooperativeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:cooperatives view')->only('index');
        //$this->middleware('permission:cooperatives edit')->only('edit');
        //$this->middleware('permission:cooperatives create')->only('create');
    }

    function index(Request $request)
    {
        return view('GrantManagement::cooperatives.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::cooperatives.form', compact('action'));
    }
    public function show(Request $request)
    {
        $cooperative = Cooperative::with(
            'province',
            'district',
            'localBody',
            'ward',
            'cooperative_type'
        )->find($request->route('id'));

        if (!$cooperative) {
            $cooperative = [];
        }

        return view('GrantManagement::cooperatives.show', compact('cooperative'));
    }



    function edit(Request $request)
    {
        $cooperative = Cooperative::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::cooperatives.form')->with(compact('action', 'cooperative'));
    }

    public function reports()
    {
        return view('GrantManagement::cooperative-report.form');

    }
}
