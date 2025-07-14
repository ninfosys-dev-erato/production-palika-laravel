<x-layout.app header="{{__('Target Entry '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.target_entries.index')}}">{{__('yojana::yojana.target_entry')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($targetEntry))
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
                            @if (!isset($targetEntry))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($targetEntry) ? __('yojana::yojana.create_target_entry') : __('yojana::yojana.update_target_entry') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.target_entries.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.target_entry_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($targetEntry))
            <livewire:yojana.target_entry_form  :$action :$targetEntry />
        @else
            <livewire:yojana.target_entry_form  :$action />
        @endif
    </div>
    </div>
            </div>
</x-layout.app>
