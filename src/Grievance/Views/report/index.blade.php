<x-layout.app header="">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grievance::grievance.grievance_report') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header">
                    <h5 class="text-primary fw-bold mb-0">{{ __('grievance::grievance.grievance_report') }}</h5>
                </div>
                <div class="card-body">
                        <livewire:grievance.report_grievance_report theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
