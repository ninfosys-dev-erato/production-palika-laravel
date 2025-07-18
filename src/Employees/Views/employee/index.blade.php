<x-layout.app :header="__('employees::employees.employee_list')">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.employee') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.employee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('employees::employees.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                   <h5 class="text-primary fw-bold">{{__('employees::employees.employee_list') }}</h5>
                    <div>
                        <a href="{{ route('admin.employee.employee.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> {{ __('employees::employees.add_employee') }}</a>
                                
                    </div>

                </div>
                <div class="card-body">
                    <livewire:employees.employee_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
