<?php

namespace Frontend\CustomerPortal\Recommendation\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;

class CustomerApplyRecommendationController extends Controller implements HasMiddleware
{
    use ApiStandardResponse;

    public static function middleware()
    {
        return [
            // new Middleware('permission:recommendation_apply_access', only: ['index']),
            // new Middleware('permission:recommendation_apply_create', only: ['create']),
            // new Middleware('permission:recommendation_apply_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('CustomerPortal.Recommendation::customer-apply-recommendation.index');
    }

    function create(Recommendation $recommendation)
    {
        $action = Action::CREATE;
        return view('CustomerPortal.Recommendation::customer-apply-recommendation.form')->with(compact('action', 'recommendation'));
    }

    function edit(Request $request)
    {
        $applyRecommendation = ApplyRecommendation::find($request->route('id'));
        $applyRecommendation->data = json_decode($applyRecommendation->data, true, 512);
        $action = Action::UPDATE;
        return view('CustomerPortal.Recommendation::customer-apply-recommendation.form')->with(compact('action', 'applyRecommendation'));
    }

    public function show(int $id)
    {

        $applyRecommendation = ApplyRecommendation::with([
            'customer',
            'form',
            'recommendation'
        ])
            ->findOrFail($id);
        return view('CustomerPortal.Recommendation::customer-apply-recommendation.show', compact('applyRecommendation'));
    }
}
