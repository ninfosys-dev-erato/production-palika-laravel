<?php

namespace Src\DigitalBoard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;

class DigitalBoardDashboardController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [];
    }

    public function index(): View
    {
        try{
            [
                $noticeCount,
                $videoCount,
                $programCount,
                $popUpCount,
                $citizenCharterCount,
               
            ] = Cache::remember('digital_board_dashboard_data', now()->addMinutes(5), function () {
                // Execute queries sequentially instead of using Concurrency::run()
                $noticeCount = Notice::whereNull('deleted_at')->count() ?? 0;
                $videoCount = Video::whereNull('deleted_at')->count() ?? 0;
                $programCount = Program::whereNull('deleted_at')->count() ?? 0;
                $popUpCount = PopUp::whereNull('deleted_at')->count() ?? 0;
                $citizenCharterCount = CitizenCharter::whereNull('deleted_at')->count() ?? 0;
                
                return [$noticeCount, $videoCount, $programCount, $popUpCount, $citizenCharterCount];
            });
        } catch (\Exception $e) {
            Cache::forget('digital_board_dashboard_data');
            return redirect()->route('admin.digital_board.index');
          
        }

        return view("DigitalBoard::dashboard", [
            
            'noticeCount' => $noticeCount,
            'videoCount' => $videoCount,
            'programCount' => $programCount,
            'popUpCount' => $popUpCount,
            'citizenCharterCount' => $citizenCharterCount,
        ]);
    }
}
