<?php

namespace Frontend\Pwa\PwaKiosk\Controllers;

use App\Http\Controllers\Controller;

class PwaKioskController extends Controller
{
    public function index($ward=0)
    {
        return view('Pwa.PwaKiosk::index', compact('ward'));
    }

    public function notice(int $ward =0)
    {
        return view('Pwa.PwaKiosk::notice',compact('ward'));
    }
    public function program($ward =0)
    {
        return view('Pwa.PwaKiosk::program',compact('ward'));
    }
    public function citizenCharter($ward =0)
    {
        return view('Pwa.PwaKiosk::citizen-charter',compact('ward'));
    }
    public function video($ward =0)
    {
        return view('Pwa.PwaKiosk::video',compact('ward'));
    }


}

