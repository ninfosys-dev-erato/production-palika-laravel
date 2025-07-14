<x-layout.app header="{{__('Agreement '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.agreements.index')}}">{{__('yojana::yojana.agreement')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($agreement))
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
                            @if (!isset($agreement))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($agreement) ? __('yojana::yojana.create_agreement') : __('yojana::yojana.update_agreement') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.agreements.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.agreement_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($agreement))
            <livewire:yojana.agreement_form  :$action :$agreement />
        @else
            <livewire:yojana.agreement_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
