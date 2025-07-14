<x-layout.app header="{{__('Test List '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.test_lists.index')}}">{{__('yojana::yojana.test_list')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($testList))
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
                            @if (!isset($testList))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($testList) ? __('yojana::yojana.create_test_list') : __('yojana::yojana.update_test_list') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.test_lists.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.test_list_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($testList))
            <livewire:yojana.test_list_form  :$action :$testList />
        @else
            <livewire:yojana.test_list_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
