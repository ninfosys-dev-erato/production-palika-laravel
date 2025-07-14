<x-layout.app header="{{__('Grant Release ' . ucfirst(strtolower($action->value)) . ' Form')}}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{route('admin.grant_release.index')}}">{{__('grantmanagement::grantmanagement.grant_release')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($grantRelease))
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
                        {{ !isset($grantRelease) ? __('grantmanagement::grantmanagement.create_grant_release') : __('grantmanagement::grantmanagement.update_grant_release') }}
                    </h5>
                    <div>
                        <a href="{{ route('admin.grant_release.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_release_list') }}
                        </a>
                    </div>

                </div>
                @if(isset($grantRelease))
                    <livewire:grant_management.grant_release_form :$action :$grantRelease />
                @else
                    <livewire:grant_management.grant_release_form :$action />
                @endif
            </div>

        </div>
    </div>


</x-layout.app>