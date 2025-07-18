<x-layout.app header="{{__('Grant '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.grants.index')}}">{{__('grantmanagement::grantmanagement.grant')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($grant))
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
                            @if (!isset($grant))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($grant) ? __('grantmanagement::grantmanagement.create_grant') : __('grantmanagement::grantmanagement.update_grant') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.grants.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($grant))
            <livewire:grant_management.grant_form  :$action :$grant />
        @else
            <livewire:grant_management.grant_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
