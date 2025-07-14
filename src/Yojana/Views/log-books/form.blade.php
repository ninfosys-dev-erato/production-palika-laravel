<x-layout.app header="{{__('Log Book '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.log_books.index')}}">{{__('yojana::yojana.log_book')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($logBook))
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
                            @if (!isset($logBook))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($logBook) ? __('yojana::yojana.create_log_book') : __('yojana::yojana.update_log_book') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.log_books.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.log_book_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($logBook))
            <livewire:yojana.log_book_form  :$action :$logBook />
        @else
            <livewire:yojana.log_book_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
