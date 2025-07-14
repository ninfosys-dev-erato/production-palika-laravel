<x-layout.app header="{{__('Mediator '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.ejalas.mediators.index')}}">{{__('ejalas::ejalas.mediator')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($mediator))
                        {{__('ejalas::ejalas.edit')}}
                    @else
                       {{__('ejalas::ejalas.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($mediator))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($mediator) ? __('ejalas::ejalas.create_mediator') : __('ejalas::ejalas.update_mediator') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.ejalas.mediators.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.mediator_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($mediator))
            <livewire:ejalas.mediator_form  :$action :$mediator />
        @else
            <livewire:ejalas.mediator_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
