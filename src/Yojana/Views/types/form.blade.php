<x-layout.app header="Type  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Type</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($type))
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
                            @if (!isset($type))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($type) ? __('yojana::yojana.create_type') : __('yojana::yojana.update_type') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.type_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($type))
            <livewire:yojana.type_form  :$action :$type />
        @else
            <livewire:yojana.type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
