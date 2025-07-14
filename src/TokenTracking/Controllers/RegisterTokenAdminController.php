<?php

namespace Src\TokenTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TokenTracking\Models\RegisterToken;

class RegisterTokenAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:register_tokens view')->only('index');
        //$this->middleware('permission:register_tokens edit')->only('edit');
        //$this->middleware('permission:register_tokens create')->only('create');
    }

    function index(Request $request)
    {
        return view('TokenTracking::index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('TokenTracking::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $registerToken = RegisterToken::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TokenTracking::form')->with(compact('action', 'registerToken'));
    }

    public function view(Request $request)
    {
        $registerToken = RegisterToken::with(['branches', 'currentBranch', 'logs'])->find($request->route('id'));
        return view('TokenTracking::show', compact('registerToken'));
    }

    public function update(Request $request, $id)
    {
        $registerToken = RegisterToken::findOrFail($id);
        $registerToken->update(['stage' => $request->query('action')]);

        return redirect()->route('admin.register_tokens.view', $registerToken->id)
            ->with('success', 'Token stage updated successfully');
    }

    public function searchToken()
    {
        return view('TokenTracking::searchToken');
    }
    public function report()
    {
        return view('TokenTracking::reportToken');
    }

    public function dashboard(Request $request)
    {
        $totalCount = RegisterToken::select('token')
            ->whereDate('created_at', now()->toDateString())
            ->distinct()
            ->count();

        $totalEntry = RegisterToken::where('stage', 'entry')
            ->whereDate('created_at', now()->toDateString())
            ->count();
        $totalRejected = RegisterToken::where('status', 'rejected')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $totalExit = RegisterToken::whereNotNull('exit_time')
            ->whereDate('created_at', now()->toDateString())
            ->count();
        $tokenBranchCounts = RegisterToken::whereDate('created_at', now()->toDateString())
            ->whereNull('deleted_at')
            ->select('current_branch')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('current_branch')
            ->orderByDesc('total')
            ->limit(6)
            ->with('currentBranch:id,title')
            ->get();

        // Calculate TokenStatStage data
        $tokenStatStage = RegisterToken::whereDate('created_at', now()->toDateString())
            ->whereNull('deleted_at')
            ->select('stage')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('stage')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn($item) => [$item->stage => $item->total])
            ->toArray();

        // Calculate Feedback data
        $feedback = RegisterToken::with('feedback')
            ->whereHas('feedback')
            ->whereDate('created_at', now()->toDateString())
            ->get()
            ->flatMap(fn($token) => $token->feedback)
            ->groupBy('citizen_satisfaction')
            ->map(fn($group) => $group->count())
            ->toArray();

        // Calculate Token Purpose data
        $purpose = RegisterToken::whereDate('created_at', now()->toDateString())
            ->whereNull('deleted_at')
            ->select('token_purpose')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('token_purpose')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(function ($item) {
                $tokenPurpose = $item->token_purpose instanceof \BackedEnum
                    ? $item->token_purpose->value
                    : $item->token_purpose;
                return [$tokenPurpose => $item->total];
            })
            ->toArray();

        return view('TokenTracking::dashboard', compact(
            'totalCount',
            'totalEntry',
            'totalExit',
            'tokenBranchCounts',
            'totalRejected',
            'tokenStatStage',
            'feedback',
            'purpose'
        ));
    }
}
