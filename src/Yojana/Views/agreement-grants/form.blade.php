<x-layout.app header="{{__('Agreement Grant '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.agreement_grants.index')}}">{{__('yojana::yojana.agreement_grant')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($agreementGrant))
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
                            @if (!isset($agreementGrant))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($agreementGrant) ? __('yojana::yojana.create_agreement_grant') : __('yojana::yojana.update_agreement_grant') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.agreement_grants.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.agreement_grant_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($agreementGrant))
            <livewire:yojana.agreement_grant_form  :$action :$agreementGrant />
        @else
            <livewire:yojana.agreement_grant_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
