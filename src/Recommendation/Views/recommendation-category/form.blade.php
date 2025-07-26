<x-layout.app header="{{ __('recommendation::recommendation.recommendation_category_form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('recommendation::recommendation.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('recommendation::recommendation.recommendation_category') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (!isset($recommendationCategory))
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
                    @if (!isset($recommendationCategory))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('recommendation::recommendation.create_recommendation_category') }}</h5>
                    @else
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('recommendation::recommendation.update_recommendation_category') }}</h5>
                    @endif
                    <div>
                        @perm('recommendation_settings access')
                            <a href="{{ route('admin.recommendations.recommendation-category.index') }}"
                                class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('recommendation::recommendation.recommendation_category_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($recommendationCategory))
                        <livewire:recommendation.recommendation_category_form :$action :$recommendationCategory />
                    @else
                        <livewire:recommendation.recommendation_category_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
