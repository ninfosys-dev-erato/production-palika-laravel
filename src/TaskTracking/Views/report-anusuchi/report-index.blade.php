<x-layout.app header="{{ __('tasktracking::tasktracking.task_tracking_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tasktracking::tasktracking.task_tracking_record') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tasktracking::tasktracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('tasktracking::tasktracking.task_tracking_record_list') }}</h5>
                    </div>
                    <div>
                        @perm('case_records create')
                            <a href="{{ route('admin.anusuchis.addReport') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('tasktracking::tasktracking.add_task_tracking_report') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:task_tracking.report_anusuchi_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
