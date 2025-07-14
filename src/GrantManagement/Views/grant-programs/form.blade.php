<x-layout.app header="{{__('Grant Program ' . ucfirst(strtolower($action->value)) . ' Form')}} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{route('admin.grant_programs.index')}}">{{__('grantmanagement::grantmanagement.grant_program')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($grantProgram))
                    {{__('grantmanagement::grantmanagement.edit')}}
                @else
                    {{__('grantmanagement::grantmanagement.create')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ !isset($grantProgram) ? __('grantmanagement::grantmanagement.create_grant_program') : __('grantmanagement::grantmanagement.update_grant_program') }}
                    </h5>
                    <div>
                        <a href="{{ route("admin.grant_programs.index")}}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_program_list') }}
                        </a>
                    </div>
                </div>
                @if(isset($grantProgram))
                    <livewire:grant_management.grant_program_form :$action :$grantProgram />
                @else
                    <livewire:grant_management.grant_program_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>