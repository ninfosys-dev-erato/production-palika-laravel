<x-layout.app header="{{__('Cash Grant ' . ucfirst(strtolower($action->value)) . ' Form')}} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{route('admin.cash_grants.index')}}">{{__('grantmanagement::grantmanagement.cash_grant')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($cashGrant))
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
                        {{ !isset($cashGrant) ? __('grantmanagement::grantmanagement.create_cash_grant') : __('grantmanagement::grantmanagement.update_cash_grant') }}
                    </h5>
                    <div>
                        <a href="{{ route("admin.cash_grants.index")}}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.cash_grant_list') }}
                        </a>
                    </div>
                </div>
                @if(isset($cashGrant))
                    <livewire:grant_management.cash_grant_form :$action :$cashGrant />
                @else
                    <livewire:grant_management.cash_grant_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>