<x-layout.app header="{{__('Farmer '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.farmers.index')}}">{{__('grantmanagement::grantmanagement.farmer')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($farmer))
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
                            @if (!isset($farmer))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($farmer) ? __('grantmanagement::grantmanagement.create_farmer') : __('grantmanagement::grantmanagement.update_farmer') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.farmers.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.farmer_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($farmer))
            <livewire:grant_management.farmer_form  :$action :$farmer />
        @else
            <livewire:grant_management.farmer_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
        
</x-layout.app>


