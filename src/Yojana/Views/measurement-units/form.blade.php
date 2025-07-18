<x-layout.app header="MeasurementUnit  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{__('yojana::yojana.measurement_unit')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($measurementUnit))
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
                            @if (!isset($measurementUnit))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($measurementUnit) ? __('yojana::yojana.create_measurementunit') : __('yojana::yojana.update_measurementunit') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.measurement_units.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.measurement_unit_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($measurementUnit))
            <livewire:yojana.measurement_unit_form  :$action :$measurementUnit />
        @else
            <livewire:yojana.measurement_unit_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
