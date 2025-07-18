<x-layout.app header="Activity Logs">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Activity Logs') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>

    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="text-primary fw-bold mb-0">
                                {{ __('Activity Logs') }}
                            </h5>
                            <div>
                                <a href="{{ route('admin.activity_logs.create') }}" class="btn btn-info"><i
                                        class="bx bx-plus"></i>
                                    {{ __('Add Activity Log') }}</a>

                            </div>
                        </div>
                        <div class="card-body">
                            <livewire:activity_logs.activity_log_table theme="bootstrap-4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
