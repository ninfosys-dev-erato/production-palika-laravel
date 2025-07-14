<?php

namespace Src\Grievance\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Employees\Models\Branch;
use Src\Grievance\Models\GrievanceType;

class GrievanceTypeController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:grievance_type_access', only: ['index']),
            new Middleware('permission:grievance_type_create', only: ['create']),
            new Middleware('permission:grievance_type_update', only: ['edit'])
        ];
    }
    function index(Request $request)
    {
        return view('Grievance::grievanceType.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Grievance::grievanceType.create')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $grievanceType = GrievanceType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Grievance::grievanceType.create')->with(compact('action', 'grievanceType'));
    }


    public function manage(Request $request)
    {
        $grievanceType = GrievanceType::find($request->route('id'));

        if (!$grievanceType) {
            return redirect()->route('admin.users.index')->with('error', 'User not found.');
        }
        return view('Grievance::grievanceType.manage', compact('grievanceType'));
    }
}
