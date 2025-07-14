<x-layout.app header="Unit  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{__('yojana::yojana.unit')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($unit))
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
                            @if (!isset($unit))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($unit) ? __('yojana::yojana.create_unit') : __('yojana::yojana.update_unit') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.units.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.unit_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($unit))
            <livewire:yojana.unit_form  :$action :$unit />
        @else
            <livewire:yojana.unit_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
