<x-layout.app header="{{__('recommendation::recommendation.recommendation_management')}}">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('recommendation::recommendation.manage_recommendation') }}</h5>
        <a href="{{ route('admin.recommendations.recommendation.index') }}" class="btn btn-info"><i
                class="bx bx-list-ul"></i>{{ __('recommendation::recommendation.recommendation_list') }}</a>
    </div>
    <div class="nav-align-left mb-6">
        <ul class="nav nav-pills me-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-detail" aria-controls="navs-pills-detail" aria-selected="true">
                    {{ __('recommendation::recommendation.recommendation_detail') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-notifees" aria-controls="navs-pills-notifees" aria-selected="false"
                    tabindex="-1">
                    {{ __('recommendation::recommendation.notifiees') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-departments" aria-controls="navs-pills-notifees" aria-selected="false"
                    tabindex="-1">
                    {{ __('recommendation::recommendation.recommendation') }} {{ __('recommendation::recommendation.department_management') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-signees" aria-controls="navs-pills-signees" aria-selected="false"
                    tabindex="-1">
                    {{ __('recommendation::recommendation.signees') }}
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-detail" role="tabpanel">
                <livewire:recommendation.recommendation_detail :$recommendation />
            </div>
            <div class="tab-pane fade" id="navs-pills-notifees" role="tabpanel">
                <div class="tab-pane fade show active" id="navs-pills-notifees" role="tabpanel">
                    <livewire:recommendation.rec_role_manage :$recommendation />
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-departments" role="tabpanel">
                <div class="tab-pane fade show active" id="navs-pills-departments" role="tabpanel">
                    <livewire:recommendation.recommendation_department_manage :$recommendation />
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-signees" role="tabpanel">
                <div class="tab-pane fade show active" id="navs-pills-signees" role="tabpanel">
                    <livewire:recommendation.recommendation_signees_manage :$recommendation />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
