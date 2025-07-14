<x-layout.app header="{{__('Plan Extension Record '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.plan_extension_records.index')}}">{{__('yojana::yojana.plan_extension_record')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($planExtensionRecord))
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
                            @if (!isset($planExtensionRecord))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($planExtensionRecord) ? __('yojana::yojana.create_plan_extension_record') : __('yojana::yojana.update_plan_extension_record') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.plan_extension_records.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.plan_extension_record_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($planExtensionRecord))
            <livewire:yojana.plan_extension_record_form  :$action :$planExtensionRecord />
        @else
            <livewire:yojana.plan_extension_record_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
