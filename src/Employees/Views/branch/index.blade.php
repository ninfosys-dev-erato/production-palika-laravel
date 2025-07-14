<x-layout.app header="Department List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.employee') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.department') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('employees::employees.list') }}</li>
        </ol>
    </nav>
    <livewire:employees.branch_index>

</x-layout.app>
