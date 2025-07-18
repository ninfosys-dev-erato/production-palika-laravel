<x-layout.app header="Department {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('employees::employees.letter_head') }}</a>
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
                    {{ __('employees::employees.department') }} {{ ucfirst(strtolower($action->value)) }}
                    <div>
                        @perm('letter_head access')
                            <a href="{{ route('admin.employee.branch.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>{{ __('employees::employees.department_list') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($branch))
                        <livewire:employees.branch_form :$action :$branch />
                    @else
                        <livewire:employees.branch_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
