<x-layout.app header='Designation List'>

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <!-- Fixed closing tag -->
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.employee') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.designation') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('employees::employees.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('employees::employees.designation_list') }}
                    <div>
                        <a href="{{ route('admin.employee.designation.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> {{ __('employees::employees.add_designation') }}</a>

                    </div>

                </div>
                <div class="card-body">
                    <livewire:employees.designation_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
