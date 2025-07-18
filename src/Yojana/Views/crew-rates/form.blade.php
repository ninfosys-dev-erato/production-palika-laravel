<x-layout.app header="CrewRate  {{ucfirst(strtolower($action->value))}} Form">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">CrewRate</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($crewRate))
                        Create
                    @else
                        Edit
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($crewRate))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($crewRate) ? __('yojana::yojana.create_crewrate') : __('yojana::yojana.update_crewrate') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.crew_rates.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.crewrate_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($crewRate))
            <livewire:crew_rates.crew_rate_form  :$action :$crewRate />
        @else
            <livewire:crew_rates.crew_rate_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
