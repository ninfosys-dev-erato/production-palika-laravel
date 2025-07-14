<x-layout.app header="{{__('Register Token Log '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.register_token_logs.index')}}">{{__('tokentracking::tokentracking.register_token_log')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($registerTokenLog))
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
                            @if (!isset($registerTokenLog))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($registerTokenLog) ? __('tokentracking::tokentracking.create_register_token_log') : __('tokentracking::tokentracking.update_register_token_log') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.register_token_logs.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('tokentracking::tokentracking.register_token_log_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($registerTokenLog))
            <livewire:token_tracking.register_token_log_form  :$action :$registerTokenLog />
        @else
            <livewire:token_tracking.register_token_log_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
