<x-layout.app header="{{__('Affiliation '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.affiliations.index')}}">{{__('grantmanagement::grantmanagement.affiliation')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($affiliation))
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
                            @if (!isset($affiliation))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($affiliation) ? __('grantmanagement::grantmanagement.create_affiliation') : __('grantmanagement::grantmanagement.update_affiliation') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.affiliations.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.affiliation_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($affiliation))
            <livewire:grant_management.affiliation_form  :$action :$affiliation />
        @else
            <livewire:grant_management.affiliation_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>

