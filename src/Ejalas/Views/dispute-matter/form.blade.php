<x-layout.app header="{{__('Dispute Matter '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.ejalas.dispute_matters.index')}}">{{__('ejalas::ejalas.dispute_matter')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($disputeMatter))
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
                            @if (!isset($disputeMatter))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($disputeMatter) ? __('ejalas::ejalas.create_dispute_matter') : __('ejalas::ejalas.update_dispute_matter') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.ejalas.dispute_matters.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.dispute_matter_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($disputeMatter))
            <livewire:ejalas.dispute_matter_form  :$action :$disputeMatter />
        @else
            <livewire:ejalas.dispute_matter_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
