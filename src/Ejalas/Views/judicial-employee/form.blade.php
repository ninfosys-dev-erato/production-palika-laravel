<x-layout.app header="{{ __('Judicial Employee ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.judicial_employees.index') }}">{{ __('ejalas::ejalas.judicial_employee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($judicialEmployee))
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
                    @if (!isset($judicialEmployee))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($judicialEmployee) ? __('ejalas::ejalas.create_judicial_employee') : __('ejalas::ejalas.update_judicial_employee') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.judicial_employees.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.judicial_employee_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($judicialEmployee))
                    <livewire:ejalas.judicial_employee_form :$action :$judicialEmployee />
                @else
                    <livewire:ejalas.judicial_employee_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
