<x-layout.app header="{{__('Implementation Agency '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.implementation_agencies.index')}}">{{__('yojana::yojana.implementation_agency')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($implementationAgency))
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
                            @if (!isset($implementationAgency))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($implementationAgency) ? __('yojana::yojana.create_implementation_agency') : __('yojana::yojana.update_implementation_agency') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.implementation_agencies.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.implementation_agency_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($implementationAgency))
            <livewire:yojana.implementation_agency_form  :$action :$implementationAgency />
        @else
            <livewire:yojana.implementation_agency_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
