<?php

namespace Src\Recommendation\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Recommendation\Models\RecommendationCategory;

class RecommendationCategoryController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:recommendation_category_access', only: ['index']),
            new Middleware('permission:recommendation_category_create', only: ['create']),
            new Middleware('permission:recommendation_category_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Recommendation::recommendation-category.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Recommendation::recommendation-category.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $recommendationCategory = RecommendationCategory::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Recommendation::recommendation-category.form')->with(compact('action', 'recommendationCategory'));
    }
}
