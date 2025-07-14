<?php

namespace Frontend\TokenPortal\TokenTv\Controllers;

use App\Http\Controllers\Controller;

class TokenTvController extends Controller
{

    public function index()
    {
        return view('TokenPortal.TokenTv::index');
    }
}