<?php

namespace Frontend\BusinessPortal\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Ebps\Models\Organization;

class OrganizationController extends Controller
{
    public function show()
    {
        $organization = Organization::with([
            'province',
            'district',
            'localBody',
            'taxClearances',
            'user'
        ])->where('id',Auth::guard('organization')->user()?->organization_id)->first();

       
        return view('BusinessPortal.Ebps::organization-show', compact('organization'));
    }

}
