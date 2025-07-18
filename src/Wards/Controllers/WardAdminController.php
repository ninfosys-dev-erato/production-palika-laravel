<?php

namespace Src\Wards\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\SessionFlash;
use Illuminate\Http\Request;
use Src\Wards\Models\Ward;
use Src\Wards\Service\WardAdminService;

class WardAdminController extends Controller
{
    use SessionFlash;
    public function __construct()
    {
        //$this->middleware('permission:wards view')->only('index');
        //$this->middleware('permission:wards edit')->only('edit');
        //$this->middleware('permission:wards create')->only('create');
    }

    function index(Request $request)
    {
        $locale = app()->getLocale();
        $wards = Ward::query()->whereNull('deleted_at')->get([
            'id',
            'local_body_id',
            'phone',
            'email',
            'address_en',
            'address_ne',
            'ward_name_en',
            'ward_name_ne',
        ])
            ->map(function ($item) use ($locale) {
                // Conditionally set the 'name' field based on the locale
                $item->title = $locale != 'en' ? $item->ward_name_ne : $item->ward_name_en;

                unset($item->ward_name_en);
                return $item;
            });
        return view('Wards::index', compact('wards'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Wards::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $ward = Ward::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Wards::form')->with(compact('action', 'ward'));
    }

    function destroy(Request $request)
    {
        $service = new WardAdminService();
        $service->delete(Ward::findOrFail($request->route('id')));
        return redirect()->back();
        // $this->successFlash("Ward Deleted Successfully");
    }
    function showUsers(Request $request, $id)
    {
        // $wardUsers = 
        return view('Wards::showuser')->with(compact('id'));
    }
    function addUser(Request $request, $selectedward)
    {
        $action = Action::CREATE;
        return view('Wards::adduser')->with(compact('action', 'selectedward'));
    }
}
