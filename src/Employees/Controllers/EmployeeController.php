<?php

namespace Src\Employees\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Employees\Models\Branch;
use Src\Employees\Models\Employee;

class EmployeeController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:employee_access', only: ['index']),
            new Middleware('permission:employee_create', only: ['create']),
            new Middleware('permission:employee_update', only: ['edit']),
        ];
    }

    public function index(Request $request)
    {
        return view('Employees::employee.index');
    }

    public function create(Request $request)
    {
        $action = Action::CREATE;
        $branchId = $request->query('branchname') ?? null; //searches branchid in route for creating
        if ($branchId) {
            $branchName = Branch::find($branchId)->title_en ?? null;
        } else {
            $branchName = null;
        }
        return view('Employees::employee.create')->with([
            'action' => $action,
            'branchName' => $branchName
        ]);
    }

    public function edit(Request $request)
    {
        $employee = Employee::find($request->route('id'));
        $action = Action::UPDATE;


        return view('Employees::employee.create')->with([
            'action' => $action,
            'employee' => $employee,
        ]);
    }
}
