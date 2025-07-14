<x-layout.app header="{{__('Enterprise Type '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.enterprise_types.index')}}">{{__('grantmanagement::grantmanagement.enterprise_type')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($enterpriseType))
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
                            @if (!isset($enterpriseType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($enterpriseType) ? __('grantmanagement::grantmanagement.create_enterprise_type') : __('grantmanagement::grantmanagement.update_enterprise_type') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.enterprise_types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.enterprise_type_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($enterpriseType))
            <livewire:grant_management.enterprise_type_form  :$action :$enterpriseType />
        @else
            <livewire:grant_management.enterprise_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
