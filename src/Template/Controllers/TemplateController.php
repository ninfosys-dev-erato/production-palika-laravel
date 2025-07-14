<?php

namespace Src\Template\Controllers;

use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function dashboard()
    {

        return view('Template::dashboard');
    }
}
