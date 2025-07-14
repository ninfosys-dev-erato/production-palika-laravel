<x-layout.app header="{{__('Collateral '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.collaterals.index')}}">{{__('Collateral')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($collateral))
                        {{__('Edit')}}
                    @else
                       {{__('Create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($collateral))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($collateral) ? __('Create Collateral') : __('Update Collateral') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.collaterals.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('Collateral List') }}
                                </a>
                            </div>
                        </div>
        @if(isset($collateral))
            <livewire:yojana.collateral_form  :$action :$collateral />
        @else
            <livewire:yojana.collateral_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
