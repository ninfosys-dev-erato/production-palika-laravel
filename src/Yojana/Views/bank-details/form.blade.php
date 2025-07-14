<x-layout.app header="{{__('Bank Detail '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.bank_details.index')}}">{{__('yojana::yojana.bank_detail')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($bankDetail))
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
                            @if (!isset($bankDetail))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($bankDetail) ? __('yojana::yojana.create_bank_detail') : __('yojana::yojana.update_bank_detail') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.bank_details.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.bank_detail_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($bankDetail))
            <livewire:yojana.bank_detail_form  :$action :$bankDetail />
        @else
            <livewire:yojana.bank_detail_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
