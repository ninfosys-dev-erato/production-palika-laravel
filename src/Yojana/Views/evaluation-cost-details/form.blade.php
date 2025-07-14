<x-layout.app header="{{__('Evaluation Cost Detail '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.evaluation_cost_details.index')}}">{{__('yojana::yojana.evaluation_cost_detail')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($evaluationCostDetail))
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
                            @if (!isset($evaluationCostDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($evaluationCostDetail) ? __('yojana::yojana.create_evaluation_cost_detail') : __('yojana::yojana.update_evaluation_cost_detail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.evaluation_cost_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.evaluation_cost_detail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($evaluationCostDetail))
            <livewire:yojana.evaluation_cost_detail_form  :$action :$evaluationCostDetail />
        @else
            <livewire:yojana.evaluation_cost_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
