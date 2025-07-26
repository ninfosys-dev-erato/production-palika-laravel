<?php

namespace Src\Recommendation\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;

class RecommendationDashboardController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        // return [
        //     new Middleware('permission:recommendation_settings access', only: ['index']),
        // ];
    }

    public function index()
    {
        try{
            [
                $recommendationCount,
                $recommendationChart,
                $appliedRecommendationCount,
                $pendingCount,
                $rejectedCount,
                $sentForPaymentCount,
                $billUploadedCount,
                $sentForApprovalCount,
                $acceptedCount,
            ] = Cache::remember('recommendation_dashboard_data', now()->addMinutes(5), function () {
                return Concurrency::run([
                    fn() => Recommendation::count(),
                    fn() =>Recommendation::withCount('applyRecommendations')
                        ->having('apply_recommendations_count', '>', 0)
                        ->orderByDesc('apply_recommendations_count')
                        ->take(10)
                        ->pluck('apply_recommendations_count', 'title')
                        ->toArray(),
                    fn() => ApplyRecommendation::count() ?? 0,
                    fn() => ApplyRecommendation::where('status', 'pending')->count() ?? 0,
                    fn() => ApplyRecommendation::where('status', 'rejected')->count() ?? 0,
                    fn() => ApplyRecommendation::where('status', 'sent for payment')->count() ?? 0,
                    fn() => ApplyRecommendation::where('status', 'bill uploaded')->count() ?? 0,
                    fn() => ApplyRecommendation::where('status', 'sent for approval')->count() ?? 0,
                    fn() => ApplyRecommendation::where('status', 'accepted')->count() ?? 0,
                ]);
            });
        } catch (\Exception $e) {
            Cache::forget('recommendation_dashboard_data');
            return redirect()->route('admin.recommendations.dashboard');
          
        }

        return view('Recommendation::dashboard', compact(
            'recommendationCount',
            'recommendationChart',
            'appliedRecommendationCount',
            'pendingCount',
            'rejectedCount',
            'sentForPaymentCount',
            'billUploadedCount',
            'sentForApprovalCount',
            'acceptedCount'
        ));
    }
}
