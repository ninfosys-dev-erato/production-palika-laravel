<x-layout.app header="{{__('Enterprise Farmer '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.enterprise_farmers.index')}}">{{__('grantmanagement::grantmanagement.enterprise_farmer')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($enterpriseFarmer))
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
                            @if (!isset($enterpriseFarmer))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($enterpriseFarmer) ? __('grantmanagement::grantmanagement.create_enterprise_farmer') : __('grantmanagement::grantmanagement.update_enterprise_farmer') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.enterprise_farmers.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.enterprise_farmer_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($enterpriseFarmer))
            <livewire:grant_management.enterprise_farmer_form  :$action :$enterpriseFarmer />
        @else
            <livewire:grant_management.enterprise_farmer_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
