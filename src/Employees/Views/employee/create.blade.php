<x-layout.app header="Employee {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.employee') }}</a>
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
                    <h5 class="text-primary fw-bold mb-0">
                        {{ $action->value === 'create' ? __('employees::employees.add_employee') : __('employees::employees.update_employee') }}</h5>
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-info"><i
                                class="bx bx-list-ol"></i>{{ __('employees::employees.employee_list') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($employee))
                        <livewire:employees.employee_form :$action :$employee />
                    @else
                        <livewire:employees.employee_form :$action :$branchName />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
