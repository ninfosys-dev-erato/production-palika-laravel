<x-layout.app header="{{__('grievance::grievance.grievance_type_management')}}">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-primary fw-bold mb-0">{{ __('grievance::grievance.manage_grievance_type') }}</h5>
        <a href="{{ route('admin.grievance.grievanceType.index') }}" class="btn btn-info"><i
                class="bx bx-list-ul"></i>{{ __('grievance::grievance.grievance_list') }}</a>
    </div>
    <div class="nav-align-left mb-6">
        <ul class="nav nav-pills me-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-detail" aria-controls="navs-pills-detail" aria-selected="true">
                    {{ __('grievance::grievance.grievance_type_detail') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-notifees" aria-controls="navs-pills-notifees" aria-selected="false"
                    tabindex="-1">
                    {{ __('grievance::grievance.notifiees') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-pills-departments" aria-controls="navs-pills-departments"
                    aria-selected="false" tabindex="-1">
                    {{ __('grievance::grievance.manage_departments') }}
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-detail" role="tabpanel">
                <livewire:grievance.grievance_type_detail :$grievanceType />
            </div>
            <div class="tab-pane fade" id="navs-pills-notifees" role="tabpanel">
                <div class="tab-pane fade show active" id="navs-pills-notifees" role="tabpanel">
                    <livewire:grievance.grievance_type_role_manage :$grievanceType />
                </div>
            </div>

            <div class="tab-pane fade" id="navs-pills-departments" role="tabpanel">
                <div class="tab-pane fade show active" id="navs-pills-departments" role="tabpanel">
                    <livewire:grievance.grievance_type_department_manage :$grievanceType />
                </div>
            </div>

        </div>
    </div>
</x-layout.app>
