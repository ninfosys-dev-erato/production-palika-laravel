<x-layout.app header="{{__('Farmer Group '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.farmer_groups.index')}}">{{__('grantmanagement::grantmanagement.farmer_group')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($farmerGroup))
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
                            @if (!isset($farmerGroup))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($farmerGroup) ? __('grantmanagement::grantmanagement.create_farmer_group') : __('grantmanagement::grantmanagement.update_farmer_group') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.farmer_groups.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.farmer_group_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($farmerGroup))
            <livewire:grant_management.farmer_group_form  :$action :$farmerGroup />
        @else
            <livewire:grant_management.farmer_group_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
