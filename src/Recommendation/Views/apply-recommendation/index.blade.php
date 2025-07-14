<x-layout.app header="{{ __('recommendation::recommendation.recommendations') }}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('recommendation::recommendation.applied_recommendation') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('recommendation::recommendation.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('recommendation::recommendation.applied_recommendation_list') }}</h5>
                    @perm('apply_recommendation_create')
                        <div>
                            <a href="{{ route('admin.recommendations.apply-recommendation.create') }}"
                                class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('recommendation::recommendation.apply_recommendation') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:recommendation.apply_recommendation_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
