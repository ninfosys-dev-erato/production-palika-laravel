<x-layout.app header="{{ __('form type') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.form-template-type.index') }}">{{ __('ejalas::ejalas.ejalas_form_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($formType))
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
                    @if (!isset($formType))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('ejalas::ejalas.form_type') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.dispute_registration_courts.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.dispute_registration_court_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($formType))
                <livewire:ejalas.form_type_form :$action :$formType />
            @else
                <livewire:ejalas.form_type_form :$action />
            @endif
            </div>
     
        </div>
    </div>
</x-layout.app>
