<x-layout.app header="{{ __('ejalas::ejalas.complaint_registration_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.complaint_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.complaint_registration_list') }}
                        </h5>
                    </div>
                    <div>
                        @perm('complaint_registrations create')
                            <a href="{{ route('admin.ejalas.complaint_registrations.create', ['from' => $from]) }}"
                                class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('ejalas::ejalas.add_complaint_registration') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    {{-- <livewire:ejalas.complaint_registration_table theme="bootstrap-4" /> --}}
                    <livewire:ejalas.complaint_registration_table theme="bootstrap-4" :from="$from" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
