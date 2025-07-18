<x-layout.app header="{{__('Agreement Cost '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.agreement_costs.index')}}">{{__('yojana::yojana.agreement_cost')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($agreementCost))
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
                            @if (!isset($agreementCost))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($agreementCost) ? __('yojana::yojana.create_agreement_cost') : __('yojana::yojana.update_agreement_cost') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.agreement_costs.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.agreement_cost_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($agreementCost))
            <livewire:yojana.agreement_cost_form  :$action :$agreementCost />
        @else
            <livewire:yojana.agreement_cost_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
