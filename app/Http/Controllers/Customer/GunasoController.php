<?php

namespace App\Http\Controllers\Customer;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Grievance\Models\GrievanceDetail;

class GunasoController extends Controller
{
    public function index()
    {
        return view("customer.gunaso.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $action = Action::CREATE;
        return view('customer.gunaso.form')->with(compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $grievanceDetail = GrievanceDetail::where('customer_id' ,Auth::guard('customer')->user()->id)
            ->with([
                'customer',
                'grievanceType',
                'branch'
                ])
            ->findOrFail($id);

        $users = User::pluck('name', 'id')->toArray();
        return view('Grievance::customerGunaso-show', compact('grievanceDetail', 'users'));
  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
