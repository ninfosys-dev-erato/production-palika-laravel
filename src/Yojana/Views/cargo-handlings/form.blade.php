<x-layout.app header="CargoHandling  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">CargoHandling</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($cargoHandling))
                        Create
                    @else
                        Edit
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($cargoHandling))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($cargoHandling) ? __('yojana::yojana.create_cargohandling') : __('yojana::yojana.update_cargohandling') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.cargo_handlings.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.cargohandling_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($cargoHandling))
            <livewire:cargo_handlings.cargo_handling_form  :$action :$cargoHandling />
        @else
            <livewire:cargo_handlings.cargo_handling_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
