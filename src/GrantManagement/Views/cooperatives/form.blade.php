<x-layout.app header="{{__('Cooperative '.ucfirst(strtolower($action->value)) .' Form')}}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.cooperative.index') }}">{{ __('grantmanagement::grantmanagement.cooperative') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($cooperative))
                    {{ __('grantmanagement::grantmanagement.edit') }}
                @else
                    {{ __('grantmanagement::grantmanagement.create') }}
                @endif
            </li>
        </ol>
    </nav>

    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($cooperative))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.create_cooperative') }}
                        </h5>
                    @else
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.update_cooperative') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.cooperative.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.cooperative_list') }}
                        </a>
                    </div>
                </div>

                @if(isset($cooperative))
                    <livewire:grant_management.cooperative_form :$action :$cooperative />
                @else
                    <livewire:grant_management.cooperative_form :$action />
                @endif

            </div>
        </div>
    </div>

</x-layout.app>
