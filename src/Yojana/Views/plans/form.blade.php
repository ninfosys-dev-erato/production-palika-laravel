<x-layout.app header="{{__($category == 'plan' ? 'Plan ' : 'Program ' .ucfirst(strtolower($action->value)) .' Form')}} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        @if($category == 'plan')
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
            <li class="breadcrumb-item"><a href="{{route('admin.plans.index')}}">{{__('yojana::yojana.plan')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($plan))
                    {{__('yojana::yojana.edit')}}
                @else
                    {{__('yojana::yojana.create')}}
                @endif
            </li>
        </ol>
        @elseif($category == 'program')
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
                <li class="breadcrumb-item"><a href="{{route('admin.programs.index')}}">{{__('yojana::yojana.program')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if(isset($plan))
                        {{__('yojana::yojana.edit')}}
                    @else
                        {{__('yojana::yojana.create')}}
                    @endif
                </li>
            </ol>
        @endif

    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card p-4">
                <div class="card-header d-flex justify-content-between mb-0">

                    @if($category == 'plan')
                        <h5 class="text-primary fw-bold mb-0">
                            {{ isset($plan) ? __('yojana::yojana.update_plan') : __('yojana::yojana.create_plan') }}</h5>
                    <div>
                        <a href="{{ route("admin.plans.index")}}"
                           class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.plan_list') }}
                        </a>
                    </div>
                    @elseif($category == 'program')
                        <h5 class="text-primary fw-bold mb-0">
                            {{ isset($plan) ? __('yojana::yojana.update_program') : __('yojana::yojana.create_program') }}</h5>
                        <div>
                            <a href="{{ route("admin.programs.index")}}"
                               class="btn btn-info">
                                <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.program_list') }}
                            </a>
                        </div>
                    @endif
                </div>
                @if(isset($plan))
                    <livewire:yojana.plan_form  :$action :$plan :$category/>
                @else
                    <livewire:yojana.plan_form  :$action :$category/>
                @endif
            </div>
        </div>
    </div>

</x-layout.app>
