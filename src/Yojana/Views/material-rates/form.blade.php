<x-layout.app header="MaterialRate  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">MaterialRate</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($materialRate))
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
                            @if (!isset($materialRate))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($materialRate) ? __('yojana::yojana.create_materialrate') : __('yojana::yojana.update_materialrate') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.material_rates.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.materialrate_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($materialRate))
            <livewire:material_rates.material_rate_form  :$action :$materialRate />
        @else
            <livewire:material_rates.material_rate_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
