<x-layout.app header="{{__('Target '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.targets.index')}}">{{__('yojana::yojana.target')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($target))
                        {{__('yojana::yojana.edit')}}
                    @else
                       {{__('yojana::yojana.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($target))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($target) ? __('yojana::yojana.create_target') : __('yojana::yojana.update_target') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.targets.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.target_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($target))
            <livewire:yojana.target_form  :$action :$target />
        @else
            <livewire:yojana.target_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
