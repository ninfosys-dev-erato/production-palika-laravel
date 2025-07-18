<?php

namespace Frontend\Pwa\PwaTv\Controllers;

use App\Http\Controllers\Controller;

class PwaTvController extends Controller
{
    public function index(int $ward = 0)
    {

        return view('Pwa.PwaTv::index',compact('ward'));
    }

}

