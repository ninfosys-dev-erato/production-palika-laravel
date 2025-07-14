<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\WorkOrder;
use Src\Yojana\Service\WorkOrderAdminService;

class WorkOrderAdminController extends Controller
{
    public $workOrderService;
    public function __construct()
    {
        //$this->middleware('permission:work_orders view')->only('index');
        //$this->middleware('permission:work_orders edit')->only('edit');
        //$this->middleware('permission:work_orders create')->only('create');
        $this->workOrderService = new WorkOrderAdminService();
    }

    function index(Request $request)
    {
        return view('Yojana::work-orders.index');
    }

    function create(Request $request)
    {
        $plan = Plan::find($request->route('plan_id'));
        $workOrder = $this->workOrderService->workOrderLetter(LetterTypes::WorkOrder, $plan);
        if (!$workOrder) {
            return redirect()->back()->with('error', 'Work order letter could not be generated.');
        }
        return redirect()->route('admin.plans.work_orders.preview', ['id' => $workOrder->id]);
    }

    function edit(Request $request)
    {
        $workOrder = WorkOrder::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::work-orders.form')->with(compact('action', 'workOrder'));
    }


    function preview(Request $request)
    {
        $model_id = $request->model_id;
        $workOrder = WorkOrder::find($request->route('id'));
        return view('Yojana::work-orders.preview', compact('workOrder','model_id'));
    }
}
