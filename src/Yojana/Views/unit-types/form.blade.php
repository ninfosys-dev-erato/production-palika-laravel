<x-layout.app header="{{__('Unit Type '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.unit_types.index')}}">{{__('yojana::yojana.unit_type')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($unitType))
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
                            @if (!isset($unitType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($unitType) ? __('yojana::yojana.create_unit_type') : __('yojana::yojana.update_unit_type') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.unit_types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.unit_type_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($unitType))
            <livewire:yojana.unit_type_form  :$action :$unitType />
        @else
            <livewire:yojana.unit_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
