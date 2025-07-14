<?php

namespace Src\Profile\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Agendas\Models\Agenda;

class UserProfileController extends Controller
{

    function index()
    {
        return view('Profile::index');
    }

    function passwordIndex()
    {
        return view('Profile::passwordIndex');
    }
}
