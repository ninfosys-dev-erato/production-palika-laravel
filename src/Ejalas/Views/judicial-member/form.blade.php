<x-layout.app header="{{__('Judicial Member '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.ejalas.judicial_members.index')}}">{{__('ejalas::ejalas.judicial_member')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($judicialMember))
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
                            @if (!isset($judicialMember))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($judicialMember) ? __('ejalas::ejalas.create_judicial_member') : __('ejalas::ejalas.update_judicial_member') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.ejalas.judicial_members.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.judicial_member_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($judicialMember))
            <livewire:ejalas.judicial_member_form  :$action :$judicialMember />
        @else
            <livewire:ejalas.judicial_member_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
