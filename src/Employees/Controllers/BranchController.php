<?php

namespace Src\Employees\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Employees\Models\Branch;
use Src\Employees\Service\BranchAdminService;


class BranchController extends Controller implements HasMiddleware
{


    public static function middleware()
    {
        return [
            new Middleware('permission:branch access', only: ['index']),
            new Middleware('permission:branch create', only: ['create']),
            new Middleware('permission:branch edit', only: ['edit']),

        ];
    }

    function index(Request $request)
    {
        
        return view('Employees::branch.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Employees::branch.create')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $branch = Branch::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Employees::branch.create')->with(compact('action', 'branch'));
    }
    public function delete($id)
    {
        if (!can('branch delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new BranchAdminService();
        $service->delete(Branch::findOrFail($id));
        // $this->successFlash("Branch Deleted Successfully");
        return redirect()->back();
    }
    public function showEmployee(Request $request, $branchname)
    {
        return view('Employees::branch.branchemployee')->with(compact('branchname'));
    }
}
