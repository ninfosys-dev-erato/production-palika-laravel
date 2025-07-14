<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\Document;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\Plan;

class PlanDashboardController extends Controller
{
    public function index(Request $request)
    {
        $plans = Plan::whereNull('deleted_at')
            ->with('implementationMethod', 'agreement', 'extensionRecords')
            ->get();

        // Initialize result to avoid undefined variable error
        $result = [
            'plan' => [],
            'program' => [],
            'labels' => []
        ];

        // Grouping by category and implementation method title
        $grouped = $plans->groupBy(['category', function ($item) {
            return optional($item->implementationMethod?->model)->label() ?? 'Unknown';
        }]);

        $allTitles = collect();

        foreach ($grouped as $category => $methods) {
            foreach ($methods as $methodTitle => $items) {
                $allTitles->push($methodTitle);
                $result[$category][$methodTitle] = $items->count();
            }
        }

        // Ensure both plan and program have values for all method titles
        $allTitles = $allTitles->unique()->values();

        foreach ($allTitles as $title) {
            $result['labels'][] = $title;
            $result['plan'][$title] = $result['plan'][$title] ?? 0;
            $result['program'][$title] = $result['program'][$title] ?? 0;
        }

        $total_plans = $plans->count();
        $total_completed_plans = $plans->where('status', PlanStatus::Completed)->count();

        $agreed_plans = $plans->filter(function ($plan) {
            return $plan->agreement && $plan->agreement()->exists();
        });
        $total_agreed_plans = $agreed_plans->count();

        $extended_plans = $plans->filter(function ($plan) {
            return $plan->extensionRecords && $plan->extensionRecords()->exists();
        });
        $total_extended_plans = $extended_plans->count();

        return view('Yojana::dashboard')
            ->with('chartdata', $result)
            ->with('total_plans', $total_plans)
            ->with('total_agreed_plans', $total_agreed_plans)
            ->with('total_completed_plans', $total_completed_plans)
            ->with('total_extended_plans', $total_extended_plans);
    }



}
