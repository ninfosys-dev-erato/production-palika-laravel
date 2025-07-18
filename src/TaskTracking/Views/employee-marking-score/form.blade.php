<x-layout.app header="{{__('Employee Marking Score '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.employee_marking_scores.index')}}">{{__('tasktracking::tasktracking.employee_marking_score')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($employeeMarkingScore))
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
                            @if (!isset($employeeMarkingScore))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($employeeMarkingScore) ? __('tasktracking::tasktracking.create_employee_marking_score') : __('tasktracking::tasktracking.update_employee_marking_score') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.employee_marking_scores.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('tasktracking::tasktracking.employee_marking_score_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($employeeMarkingScore))
            <livewire:task_tracking.employee_marking_score_form  :$action :$employeeMarkingScore />
        @else
            <livewire:task_tracking.employee_marking_score_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
