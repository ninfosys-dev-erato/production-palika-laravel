<?php

namespace Src\Recommendation\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Recommendation\Models\Recommendation;

class RecommendationController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:recommendation_access', only: ['index']),
            new Middleware('permission:recommendation_create', only: ['create']),
            new Middleware('permission:recommendation_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Recommendation::recommendation.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Recommendation::recommendation.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $recommendation = Recommendation::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Recommendation::recommendation.form')->with(compact('action', 'recommendation'));
    }

    public function manage(Request $request)
    {
        $recommendation = Recommendation::with('createdBy', 'form', 'recommendationCategory')->find($request->route('id'));
       

        if (!$recommendation) {
            return redirect()->route('admin.recommendation.index')->with('error', 'Recommendation not found.');
        }
        return view('Recommendation::recommendation.manage', compact('recommendation'));
    }

    public function notification()
    {
        return view("Recommendation::notification");
    }
}
