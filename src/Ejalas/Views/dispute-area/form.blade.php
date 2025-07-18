<x-layout.app header="{{__('Dispute Area '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.ejalas.dispute_areas.index')}}">{{__('ejalas::ejalas.dispute_area')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($disputeArea))
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
                            @if (!isset($disputeArea))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($disputeArea) ? __('ejalas::ejalas.create_dispute_area') : __('ejalas::ejalas.update_dispute_area') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.ejalas.dispute_areas.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.dispute_area_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($disputeArea))
            <livewire:ejalas.dispute_area_form  :$action :$disputeArea />
        @else
            <livewire:ejalas.dispute_area_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
