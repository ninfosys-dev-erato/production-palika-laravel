<?php

namespace Src\GrantManagement\Controllers;
use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashGrantReportsAdminController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::grant-cash-reports.form')->with(compact('action'));
    }

    function create(Request $request)
    {

    }

    public function show()
    {

    }
}