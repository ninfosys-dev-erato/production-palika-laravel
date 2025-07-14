<x-layout.app header="{{__('Committee Type '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.committee-types.index')}}">{{__('yojana::yojana.committee_type')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($committeeType))
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
                            @if (!isset($committeeType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($committeeType) ? __('yojana::yojana.create_committee_type') : __('yojana::yojana.update_committee_type') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.committee-types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.committee_type_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($committeeType))
            <livewire:yojana.committee_type_form  :$action :$committeeType />
        @else
            <livewire:yojana.committee_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
