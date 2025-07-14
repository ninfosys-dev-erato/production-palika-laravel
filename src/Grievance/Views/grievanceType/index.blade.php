<x-layout.app header="{{ __('grievance::grievance.grievance_type') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grievance::grievance.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold">{{ __('grievance::grievance.grievance_type') }}</h5>
                    @perm('grievance_type_create')
                        <div>
                            <a href="{{ route('admin.grievance.grievanceType.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('grievance::grievance.add_grievance_type') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:grievance.grievance_type_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
