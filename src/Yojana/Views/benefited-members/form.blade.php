<x-layout.app header="{{ __('Benefited Member ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.benefited_members.index') }}">{{ __('yojana::yojana.benefited_member') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($benefitedMember))
                    {{ __('yojana::yojana.edit') }}
                @else
                    {{ __('yojana::yojana.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($benefitedMember))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($benefitedMember) ? __('yojana::yojana.create_benefited_member') : __('yojana::yojana.update_benefited_member') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.benefited_members.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.benefited_member_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($benefitedMember))
                    <livewire:yojana.benefited_member_form :$action :$benefitedMember />
                @else
                    <livewire:yojana.benefited_member_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
