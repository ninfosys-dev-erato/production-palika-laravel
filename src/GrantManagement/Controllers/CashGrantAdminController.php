<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\CashGrant;

class CashGrantAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:cash_grants view')->only('index');
        //$this->middleware('permission:cash_grants edit')->only('edit');
        //$this->middleware('permission:cash_grants create')->only('create');
    }

    function index(Request $request)
    {
        return view('GrantManagement::cash-grants.index');
    }

    function show(Request $request)
    {
        $cashGrant = CashGrant::with(['ward', 'user', 'getHelplessnessType'])->find($request->route('id'));

        $fileUrl = null;
        if ($cashGrant->file) {
            $fileUrl = FileFacade::getTemporaryUrl(
                path: config('src.GrantManagement.grant.file'),
                filename: $cashGrant->file,
                disk: getStorageDisk('private')
            );
        }

        if (!$cashGrant) {
            $cashGrant = [];
        }
        return view('GrantManagement::cash-grants.show')->with(compact('cashGrant', 'fileUrl'));
    }


    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::cash-grants.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $cashGrant = CashGrant::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::cash-grants.form')->with(compact('action', 'cashGrant'));
    }

    function reports(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::grant-cash-reports.form')->with(compact('action'));
    }
}
