<x-layout.app header="{{__('Item Type '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.item_types.index')}}">{{__('yojana::yojana.item_type')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($itemType))
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
                            @if (!isset($itemType))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($itemType) ? __('yojana::yojana.create_item_type') : __('yojana::yojana.update_item_type') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.item_types.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.item_type_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($itemType))
            <livewire:yojana.item_type_form  :$action :$itemType />
        @else
            <livewire:yojana.item_type_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
