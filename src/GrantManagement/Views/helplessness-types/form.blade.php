<x-layout.app header="{{__('Helplessness Type '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.helplessness_types.index')}}">{{__('grantmanagement::grantmanagement.helplessness_type')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($helplessnessType))
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
                            @if (!isset($helplessnessType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($helplessnessType) ? __('grantmanagement::grantmanagement.create_helplessness_type') : __('grantmanagement::grantmanagement.update_helplessness_type') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.helplessness_types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.helplessness_type_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($helplessnessType))
            <livewire:grant_management.helplessness_type_form  :$action :$helplessnessType />
        @else
            <livewire:grant_management.helplessness_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
