<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\Farmer;

class FarmerAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:farmers view')->only('index');
        //$this->middleware('permission:farmers edit')->only('edit');
        //$this->middleware('permission:farmers create')->only('create');
    }

    function index(Request $request)
    {
        return view('GrantManagement::farmers.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::farmers.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $farmer = Farmer::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::farmers.form')->with(compact('action', 'farmer'));
    }

    public function show(Request $request)
    {
        $farmer = Farmer::with([
            'province',
            'district',
            'localBody',
            'groups',
            'ward',
            'cooperatives',
            'enterprises',
            'user'
        ])->find($request->route('id'));

        if (!$farmer) {
            return view('GrantManagement::farmers.show')->with([
                'farmer' => null,
                'relatedFarmers' => []
            ]);
        }

        $relatedFarmers = Farmer::whereIn('id', $farmer->farmer_ids ?? [])->get();

        return view('GrantManagement::farmers.show')->with([
            'farmer' => $farmer,
            'relatedFarmers' => $relatedFarmers
        ]);
    }


    public function reports()
    {
        $action = Action::CREATE;
        return view('GrantManagement::farmer-reports.form')->with(compact('action'));
    }
}
