<x-layout.app header="{{ __('ejalas::ejalas.hearing_schedule_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.hearing_schedule') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.hearing_schedule_list') }}</h5>
                    </div>
                    <div>
                        @perm('jms_judicial_management create')
                            <a href="{{ route('admin.ejalas.hearing_schedules.create', ['from' => $from]) }}"
                                class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('ejalas::ejalas.add_hearing_schedule') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:ejalas.hearing_schedule_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
