<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GlobalService{

    /*
        For User|Business|Customer model to set wards
        just incase EG: User can be of many ward but needs to do operation on behalf
        of a single ward ( Implement for safety ) on user login ;)
    */
    public function ward(int $ward = null)
    {
        if ($ward) {
            Session::put('ward', $ward);
        } else {
            return Session::has('ward') ? Session::get('ward') : null;
        }
    }

    public function localBody(int $localBody = null)
    {
        if($localBody){
            Session::put('local-body', $localBody);

        }else{
            return session()->get('local-body');
        }
    }

    public function department(int $department = null): ?int
    {
        if (!is_null($department)) {
            session()->put('department', $department);
            return $department;
        }

        $stored = session()->get('department');

        return is_numeric($stored) ? (int) $stored : null;
    }

    public function authUser(int $userId = null)
    {
        if ($userId) {
            Session::put('user-id', $userId);
        } else {
            return session()->get('user-id', Auth::id());
        }
    }
}