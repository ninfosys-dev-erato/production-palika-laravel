<x-layout.app header="{{ __('Agreement Format ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.agreement_formats.index') }}">{{ __('yojana::yojana.agreement_format') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($agreementFormat))
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
                    @if (!isset($agreementFormat))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($agreementFormat) ? __('yojana::yojana.create_agreement_format') : __('yojana::yojana.update_agreement_format') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.agreement_formats.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.agreement_format_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($agreementFormat))
                    <livewire:yojana.agreement_format_form :$action :$agreementFormat />
                @else
                    <livewire:yojana.agreement_format_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
