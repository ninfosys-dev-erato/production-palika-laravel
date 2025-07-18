<?php

namespace Src\Meetings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;
use Src\Meetings\Models\Meeting;
use Src\Yojana\Models\CommitteeType;

class MeetingDashboardController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:meeting_access', only: ['index']),
        ];
    }

    public function index()
    {
        try {

            [
                $meetingCount,
                $todaysMeetingCount,
                $upcomingMeetings,
                $completedMeetings,
                $meetingChart,
                $commiteeMember,
                $meetingsByCommittee
            ] = Cache::remember('meeting_dashboard_data', now()->addMinutes(5), function () {
                return Concurrency::run([
                    fn () => Meeting::count(),
                    fn () => Meeting::whereDate('created_at', now()->toDateString())->count(),
                    fn () => Meeting::whereDate('start_date', '>=', now()->toDateString())->count(),
                    fn () => Meeting::whereDate('end_date', '<', now()->toDateString())->count(),
                    fn () => CommitteeType::withCount('meetings')->latest()->get()->pluck('meetings_count', 'name')->toArray(),
                    fn () => DB::table('met_committee_members')->count(),
                    fn () => Meeting::withCount('committee')->get(),
                ]);
            });
        } catch (\Exception $e) {
            Cache::forget('meeting_dashboard_data');
            return redirect()->route('admin.meetings.dashboard');
        }

        return view('Meetings::dashboard', compact([
            'meetingCount',
            'todaysMeetingCount',
            'upcomingMeetings',
            'completedMeetings',
            'meetingChart',
            'commiteeMember',
            'meetingsByCommittee',
        ]));
    }
}
