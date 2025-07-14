<x-layout.app header="{{__('Organization '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.organizations.index')}}">{{__('yojana::yojana.organization')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($organization))
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
                            @if (!isset($organization))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($organization) ? __('yojana::yojana.create_organization') : __('yojana::yojana.update_organization') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.organizations.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.organization_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($organization))
            <livewire:yojana.organization_form  :$action :$organization />
        @else
            <livewire:yojana.organization_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
