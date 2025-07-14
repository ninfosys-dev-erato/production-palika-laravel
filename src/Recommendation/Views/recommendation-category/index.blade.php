<x-layout.app header="{{ __('recommendation::recommendation.recommendation_category') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('recommendation::recommendation.recommendation_category') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('recommendation::recommendation.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold">
                        {{ __('recommendation::recommendation.recommendation_category_list') }}</h5>
                    @perm('recommendation_category_create')
                        <div>
                            <a href="{{ route('admin.recommendations.recommendation-category.create') }}"
                                class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('recommendation::recommendation.add_recommendation_category') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:recommendation.recommendation_category_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
