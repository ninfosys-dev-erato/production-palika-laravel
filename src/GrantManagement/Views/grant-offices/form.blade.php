<x-layout.app header="{{__('Grant Office '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.grant_offices.index')}}">{{__('grantmanagement::grantmanagement.grant_office')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($grantOffice))
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
                            @if (!isset($grantOffice))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($grantOffice) ? __('grantmanagement::grantmanagement.create_grant_office') : __('grantmanagement::grantmanagement.update_grant_office') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.grant_offices.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_office_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($grantOffice))
            <livewire:grant_management.grant_office_form  :$action :$grantOffice />
        @else
            <livewire:grant_management.grant_office_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
