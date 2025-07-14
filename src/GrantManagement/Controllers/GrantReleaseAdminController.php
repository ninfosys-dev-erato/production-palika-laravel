<?php

namespace Src\GrantManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\Action;
use Src\GrantManagement\Models\GrantRelease;

class GrantReleaseAdminController extends Controller
{

    public function __construct()
    {

    }

    function index(Request $request)
    {
        return view('GrantManagement::grant-release.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::grant-release.form')->with(compact('action'));
    }
    public function show(Request $request)
    {
        // Attempt to find the GrantRelease record by ID
        $grantRelease = GrantRelease::find($request->route('id'));

        // If no GrantRelease record is found, return an empty array
        if (!$grantRelease) {
            $grantRelease = [];
        }

        // If a GrantRelease is found, proceed to get the grantee
        if (!empty($grantRelease)) {
            $grantee = app($grantRelease->grantee_type)::find($grantRelease->grantee_id);

            // If no grantee is found, set $grantee to an empty array
            if (!$grantee) {
                $grantee = [];
            }

            // Determine the grantee name based on the table of the grantee
            if (!empty($grantee) && in_array($grantee->getTable(), ['gms_cooperatives', 'gms_groups', 'gms_enterprises'])) {
                $granteeName = $grantee->name ?? 'Unknown';
            } elseif (!empty($grantee) && $grantee->getTable() === 'gms_farmers') {
                $granteeName = collect([$grantee->first_name, $grantee->middle_name, $grantee->last_name])
                    ->filter()
                    ->join(' ') ?? 'Unknown';
            } else {
                $granteeName = 'Unknown';
            }
        } else {
            // If grantRelease is empty, set granteeName to 'Unknown'
            $granteeName = 'Unknown';
            $grantee = [];
        }

        // Return the view with the GrantRelease, grantee, and granteeName
        return view('GrantManagement::grant-release.show', compact('grantRelease', 'grantee', 'granteeName'));
    }



    function edit(Request $request)
    {
        $grantRelease = GrantRelease::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::grant-release.form')->with(compact('action', 'grantRelease'));
    }

    function reports()
    {
        $action = Action::CREATE;
        return view('GrantManagement::grant-release-report.form')->with(compact('action'));

    }
}