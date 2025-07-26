<?php
use Illuminate\Support\Facades\Cache;
$service = new \Src\Recommendation\Services\RecommendationAdminService();
$categories = Cache::remember('recommendation_category_tree', 60, function () use ($service) {
    return $service->categoryTree();
});
?>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.recommendations.apply-recommendation.index', 'admin.recommendations.apply-recommendation.*') ? 'active' : '' }}">
    <a href="{{ route('admin.recommendations.apply-recommendation.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-file"></i>
        <div data-i18n="Recommendation">{{ __('recommendation::recommendation.applied_recommendation') }}</div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span
        class="menu-header-text">{{ __('recommendation::recommendation.apply') . ' ' . __('recommendation::recommendation.recommendation') }}</span>
</li>
@perm('recommendation_apply access')
    @foreach ($categories as $category)
        @if ($category['recommendations_count'] > 0)
            <li class="menu-item" style="">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
                    <div data-i18n="{{ $category['title'] }}">{{ $category['title'] }} </div>
                </a>
                @foreach ($category['recommendations'] as $recommendation)
                    <ul class="menu-sub">
                        <li class="menu-item ">
                            <a href="{{ route('admin.recommendations.apply-recommendation.create', ['recommendation' => $recommendation['id']]) }}"
                                class="menu-link">
                                <div data-i18n="{{ $recommendation['title'] }}">{{ $recommendation['title'] }}</div>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </li>
        @endif
    @endforeach
@endperm


<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('recommendation::recommendation.report') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.recommendations.report') ? 'active' : '' }}">
    <a href="{{ route('admin.recommendations.report') }}" class="menu-link">
        <div data-i18n="Recommendation Report">{{ __('recommendation::recommendation.recommendation_report') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span
        class="menu-header-text">{{ __('recommendation::recommendation.recommendation') . ' ' . __('recommendation::recommendation.settings') }}</span>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.recommendations.recommendation-category.index', 'admin.recommendations.recommendation-category.*') ? 'active' : '' }}">
    <a href="{{ route('admin.recommendations.recommendation-category.index') }}" class="menu-link">
        <div data-i18n="RecommendationCategory">{{ __('recommendation::recommendation.recommendation_category') }}
        </div>
    </a>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is(
        'admin.recommendations.recommendation.index',
        'admin.recommendations.recommendation.*',
    ) && !\Illuminate\Support\Facades\Route::is('admin.recommendations.recommendation.notification')
        ? 'active'
        : '' }}">
    <a href="{{ route('admin.recommendations.recommendation.index') }}" class="menu-link">
        <div data-i18n="Recommendation">{{ __('recommendation::recommendation.recommendation_form') }}</div>
    </a>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.recommendations.recommendation.notification') ? 'active' : '' }}">
    <a href="{{ route('admin.recommendations.recommendation.notification') }}" class="menu-link">
        <div data-i18n="Account Settings">{{ __('recommendation::recommendation.notification_setting') }}</div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.recommendations.form-template.*') ? 'active' : '' }}">
    <a href="{{ route('admin.recommendations.form-template.index') }}" class="menu-link">
        <div data-i18n="Recommendation">{{ __('recommendation::recommendation.recommendation_form_template') }}</div>
    </a>
</li>
