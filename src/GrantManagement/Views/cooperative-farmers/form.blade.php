<x-layout.app header="{{__('Cooperative Farmer '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.cooperative_farmers.index')}}">{{__('grantmanagement::grantmanagement.cooperative_farmer')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($cooperativeFarmer))
                        {{__('grantmanagement::grantmanagement.edit')}}
                    @else
                       {{__('grantmanagement::grantmanagement.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($cooperativeFarmer))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($cooperativeFarmer) ? __('grantmanagement::grantmanagement.create_cooperative_farmer') : __('grantmanagement::grantmanagement.update_cooperative_farmer') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.cooperative_farmers.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.cooperative_farmer_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($cooperativeFarmer))
            <livewire:grant_management.cooperative_farmer_form  :$action :$cooperativeFarmer />
        @else
            <livewire:grant_management.cooperative_farmer_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
