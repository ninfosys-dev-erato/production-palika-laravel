<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BenefitedMember;

class BenefitedMemberAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:benefited_members view')->only('index');
        //$this->middleware('permission:benefited_members edit')->only('edit');
        //$this->middleware('permission:benefited_members create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::benefited-members.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::benefited-members.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $benefitedMember = BenefitedMember::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::benefited-members.form')->with(compact('action', 'benefitedMember'));
    }
}
