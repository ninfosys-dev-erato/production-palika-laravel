<?php

namespace Domains\AdminGateway\Dashboard\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiStandardResponse;
use Src\Grievance\Models\GrievanceDetail;
use Src\Recommendation\Models\ApplyRecommendation;
use Carbon\Carbon;

class AdminDashboardHandler extends Controller
{
    use ApiStandardResponse;

    public function dashboardCounts(): JsonResponse
    {
        $today = Carbon::today();

        // Total counts
        $grievanceCount = GrievanceDetail::whereNull('deleted_at')->count();
        $recommendationCount = ApplyRecommendation::whereNull('deleted_at')->count();

        // Today's entries
        $todayGrievances = GrievanceDetail::whereNull('deleted_at')
            ->whereDate('created_at', $today)
            ->get();

        $todayRecommendations = ApplyRecommendation::whereNull('deleted_at')
            ->whereDate('created_at', $today)
            ->get();

        return $this->generalSuccess([
            'message' => 'Dashboard data',
            'grievanceCount' => $grievanceCount,
            'recommendationCount' => $recommendationCount,
            'todayGrievances' => $todayGrievances,
            'todayRecommendations' => $todayRecommendations,
        ]);
    }
}
