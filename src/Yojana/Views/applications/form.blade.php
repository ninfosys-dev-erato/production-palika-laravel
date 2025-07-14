<x-layout.app header="{{__('Application '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.applications.index')}}">{{__('yojana::yojana.application')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($application))
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
                            @if (!isset($application))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($application) ? __('yojana::yojana.create_application') : __('yojana::yojana.update_application') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.applications.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.application_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($application))
            <livewire:yojana.application_form  :$action :$application />
        @else
            <livewire:yojana.application_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
