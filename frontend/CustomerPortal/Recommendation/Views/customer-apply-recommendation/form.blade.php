<x-layout.customer-app header="{{ __('recommendation::recommendation.recommendation_application_form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('recommendation::recommendation.recommendation') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($applyRecommendation))
                    {{ __('recommendation::recommendation.create') }}
                @else
                    {{ __('recommendation::recommendation.edit') }}
                @endif
            </li>
        </ol>
    </nav>

    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">

                    <div class="d-flex justify-content-between card-header">
                        @if (!isset($applyRecommendation))
                            <h5 class="text-primary fw-bold mb-0">
                                {{ __('recommendation::recommendation.apply_recommendation') }}</h5>
                        @else
                            <h5 class="text-primary fw-bold mb-0">
                                {{ __('recommendation::recommendation.update_applied_recommendation') }}</h5>
                        @endif
                    </div>
                    <div>

                        <a href="{{ route('customer.recommendations.apply-recommendation.index') }}"
                            class="btn btn-info">
                            <i
                                class="bx bx-list-ol"></i>{{ __('recommendation::recommendation.applied_recommendation_list') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (isset($applyRecommendation))
                        <livewire:customer_portal.recommendation.customer_apply_recommendation_form :$action
                            :$applyRecommendation />
                    @else
                        <livewire:customer_portal.recommendation.customer_apply_recommendation_form :action="$action"
                            :recommendation="$recommendation" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
