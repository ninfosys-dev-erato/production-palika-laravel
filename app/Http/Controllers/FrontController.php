<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('admin.front', compact([]));
    }
    public function login()
    {
        if (\auth('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('admin.digital-service');
    }

    public function services()
    {
        if (\auth('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('admin.service');

    }
}
