<x-layout.app header="TechnicalCostEstimate  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">TechnicalCostEstimate</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($technicalCostEstimate))
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
                            @if (!isset($technicalCostEstimate))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($technicalCostEstimate) ? __('yojana::yojana.create_technicalcostestimate') : __('yojana::yojana.update_technicalcostestimate') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.technical_cost_estimates.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.technicalcostestimate_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($technicalCostEstimate))
            <livewire:technical_cost_estimates.technical_cost_estimate_form  :$action :$technicalCostEstimate />
        @else
            <livewire:technical_cost_estimates.technical_cost_estimate_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
