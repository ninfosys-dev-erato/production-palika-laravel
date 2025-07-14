<x-layout.app header="{{__('Employee Marking '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.employee_markings.index')}}">{{__('tasktracking::tasktracking.employee_marking')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($employeeMarking))
                        {{__('tasktracking::tasktracking.edit')}}
                    @else
                       {{__('tasktracking::tasktracking.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($employeeMarking))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($employeeMarking) ? __('tasktracking::tasktracking.create_employee_marking') : __('tasktracking::tasktracking.update_employee_marking') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.employee_markings.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('tasktracking::tasktracking.employee_marking_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($employeeMarking))
            <livewire:task_tracking.employee_marking_form  :$action :$employeeMarking />
        @else
            <livewire:task_tracking.employee_marking_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
