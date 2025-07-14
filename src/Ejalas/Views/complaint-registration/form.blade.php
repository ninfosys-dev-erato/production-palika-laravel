<x-layout.app header="{{ __('Complaint Registration ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.complaint_registrations.index', ['from' => $from]) }}">{{ __('ejalas::ejalas.complaint_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($complaintRegistration))
                    {{ __('ejalas::ejalas.edit') }}
                @else
                    {{ __('ejalas::ejalas.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <!-- Registration Form -->
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($complaintRegistration))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($complaintRegistration) ? __('ejalas::ejalas.create_complaint_registration') : __('ejalas::ejalas.update_complaint_registration') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.complaint_registrations.index', ['from' => $from]) }}"
                            class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.complaint_registration_list') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if (isset($complaintRegistration))
        <livewire:ejalas.complaint_registration_form :$action :$complaintRegistration :$from />
    @else
        <livewire:ejalas.complaint_registration_form :$action :$from />
    @endif

</x-layout.app>
