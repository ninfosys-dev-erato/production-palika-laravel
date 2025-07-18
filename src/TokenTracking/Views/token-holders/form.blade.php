<x-layout.app header="{{__('Token Holder '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.token_holders.index')}}">{{__('tokentracking::tokentracking.token_holder')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($tokenHolder))
                        {{__('tokentracking::tokentracking.edit')}}
                    @else
                       {{__('tokentracking::tokentracking.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($tokenHolder))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($tokenHolder) ? __('tokentracking::tokentracking.create_token_holder') : __('tokentracking::tokentracking.update_token_holder') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.token_holders.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('tokentracking::tokentracking.token_holder_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($tokenHolder))
            <livewire:token_tracking.token_holder_form  :$action :$tokenHolder />
        @else
            <livewire:token_tracking.token_holder_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
