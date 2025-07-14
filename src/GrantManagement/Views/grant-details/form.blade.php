<x-layout.app header="{{__('Grant Detail '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.grant_details.index')}}">{{__('grantmanagement::grantmanagement.grant_detail')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($grantDetail))
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
                            @if (!isset($grantDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($grantDetail) ? __('grantmanagement::grantmanagement.create_grant_detail') : __('grantmanagement::grantmanagement.update_grant_detail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.grant_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_detail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($grantDetail))
            <livewire:grant_management.grant_detail_form  :$action :$grantDetail />
        @else
            <livewire:grant_management.grant_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
