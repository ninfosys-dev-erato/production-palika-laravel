<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\ComplaintRegistration;

class AnusuchiFormAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:court_notices view')->only('index');
        //$this->middleware('permission:court_notices edit')->only('edit');
        //$this->middleware('permission:court_notices create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::anusuchiform.index');
    }


    function preview(Request $request)
    {
        $complaintRegistration = ComplaintRegistration::findOrFail($request->route('id'));

        return view('Ejalas::anusuchiform.preview', compact('complaintRegistration'));
    }
}
