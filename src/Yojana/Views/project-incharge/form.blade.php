<x-layout.app header="{{__('Project Incharge '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.project_incharge.index')}}">{{__('yojana::yojana.project_incharge')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($projectIncharge))
                        {{__('yojana::yojana.edit')}}
                    @else
                       {{__('yojana::yojana.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($projectIncharge))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($projectIncharge) ? __('yojana::yojana.create_project_incharge') : __('yojana::yojana.update_project_incharge') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.project_incharge.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.project_incharge_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($projectIncharge))
            <livewire:yojana.project_incharge_form  :$action :$projectIncharge />
        @else
            <livewire:yojana.project_incharge_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
