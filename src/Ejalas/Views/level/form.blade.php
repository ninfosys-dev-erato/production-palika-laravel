<x-layout.app header="{{__('Level '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.ejalas.levels.index')}}">{{__('ejalas::ejalas.level')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($level))
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
                            @if (!isset($level))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($level) ? __('ejalas::ejalas.create_level') : __('ejalas::ejalas.update_level') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.ejalas.levels.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.level_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($level))
            <livewire:ejalas.level_form  :$action :$level />
        @else
            <livewire:ejalas.level_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
