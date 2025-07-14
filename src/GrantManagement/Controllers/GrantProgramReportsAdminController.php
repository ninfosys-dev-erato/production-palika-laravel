<?php

namespace Src\GrantManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\Action;

class GrantProgramReportsAdminController extends Controller{
    public function __construct(){

    }

    function index(Request $request)
    {
        $action = Action::CREATE;

        return view('GrantManagement::grant-programs-reports.index')->with(compact('action'));
    }

}