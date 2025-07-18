<x-layout.app header="Employee List">
    <div class="card">

        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary fw-bold">{{ __('employees::employees.employee_list') }}</h5>
            <div>
                @perm('users_create')
                    <a href="{{ route('admin.employee.employee.create', ['branchname' => $branchname]) }}"
                        class="btn btn-info"><i class="bx bx-plus"></i>
                        {{ __('employees::employees.add_employee') }}</a>
                @endperm
            </div>
        </div>
        <div class="card-body">
            <livewire:employees.employee_table :$branchname theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
