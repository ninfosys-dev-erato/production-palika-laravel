<x-layout.app header="LabourRate  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">LabourRate</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($labourRate))
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
                            @if (!isset($labourRate))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($labourRate) ? __('yojana::yojana.create_labourrate') : __('yojana::yojana.update_labourrate') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.labour_rates.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.labourrate_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($labourRate))
            <livewire:labour_rates.labour_rate_form  :$action :$labourRate />
        @else
            <livewire:labour_rates.labour_rate_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
