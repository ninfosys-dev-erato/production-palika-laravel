<x-layout.app header="{{__('Criterion '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.criteria.index')}}">{{__('tasktracking::tasktracking.criterion')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($criterion))
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
                            @if (!isset($criterion))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($criterion) ? __('tasktracking::tasktracking.create_criterion') : __('tasktracking::tasktracking.update_criterion') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.criteria.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('tasktracking::tasktracking.criterion_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($criterion))
            <livewire:task_tracking.criterion_form  :$action :$criterion />
        @else
            <livewire:task_tracking.criterion_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
