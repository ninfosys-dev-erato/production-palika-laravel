<x-layout.app header="{{__('Item '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
                <li class="breadcrumb-item"><a href="{{route('admin.items.index')}}">{{__('yojana::yojana.item')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($item))
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
                            @if (!isset($item))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($item) ? __('yojana::yojana.create_item') : __('yojana::yojana.update_item') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.items.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.item_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($item))
            <livewire:yojana.item_form  :$action :$item />
        @else
            <livewire:yojana.item_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
