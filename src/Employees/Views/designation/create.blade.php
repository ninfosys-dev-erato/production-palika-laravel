<x-layout.app header="Designation {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.designation') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ ucfirst(strtolower($action->value)) }}
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('employees::employees.designation') }} {{ ucfirst(strtolower($action->value)) }}
                    <div>
                        <a href="{{ route('admin.employee.designation.index') }}" class="btn btn-info"><i
                                class="bx bx-list-ol"></i>{{ __('employees::employees.designation_list') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($designation))
                        <livewire:employees.designation_form :$action :$designation />
                    @else
                        <livewire:employees.designation_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
