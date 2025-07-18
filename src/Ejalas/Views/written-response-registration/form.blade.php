<x-layout.app header="{{ __('Written Response Registration ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.written_response_registrations.index') }}">{{ __('ejalas::ejalas.written_response_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($writtenResponseRegistration))
                    {{ __('ejalas::ejalas.edit') }}
                @else
                    {{ __('ejalas::ejalas.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($writtenResponseRegistration))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($writtenResponseRegistration) ? __('ejalas::ejalas.create_written_response_registration') : __('ejalas::ejalas.update_written_response_registration') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.written_response_registrations.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.written_response_registration_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($writtenResponseRegistration))
                    <livewire:ejalas.written_response_registration_form :$action :$writtenResponseRegistration />
                @else
                    <livewire:ejalas.written_response_registration_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
