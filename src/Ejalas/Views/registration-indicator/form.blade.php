<x-layout.app header="{{__('Registration Indicator '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.ejalas.registration_indicators.index')}}">{{__('ejalas::ejalas.registration_indicator')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($registrationIndicator))
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
                            @if (!isset($registrationIndicator))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($registrationIndicator) ? __('ejalas::ejalas.create_registration_indicator') : __('ejalas::ejalas.update_registration_indicator') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.ejalas.registration_indicators.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.registration_indicator_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($registrationIndicator))
            <livewire:ejalas.registration_indicator_form  :$action :$registrationIndicator />
        @else
            <livewire:ejalas.registration_indicator_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
