<x-layout.app header="{{ __('grantmanagement::grantmanagement.cooperative_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grantmanagement::grantmanagement.cooperative') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grantmanagement::grantmanagement.show') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.cooperative_list') }}
                        </h5>
                    </div>
                    <div>
                        @perm('gms_activity create')
                            <a href="{{ route('admin.cooperative.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('grantmanagement::grantmanagement.add_cooperative') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">
                                    {{ __('grantmanagement::grantmanagement.cooperative') }}
                                </h6>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.name') }}:</strong>
                                    {{ $cooperative->name ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.cooperative_type') }}:</strong>
                                    {{ $cooperative->cooperative_type->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.registration_no') }}:</strong>
                                    {{ $cooperative->registration_no ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.registration_date') }}:</strong>
                                    {{ $cooperative->registration_date ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.vat_pan') }}:</strong>
                                    {{ $cooperative->vat_pan ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.objective') }}:</strong>
                                    {{ $cooperative->objective ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">
                                    {{ __('grantmanagement::grantmanagement.permanent_address') }}
                                </h6>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.province') }}:</strong>
                                    {{ $cooperative->province->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.district') }}:</strong>
                                    {{ $cooperative->district->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.local_body') }}:</strong>
                                    {{ $cooperative->localBody->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.ward') }}:</strong>
                                    {{ $cooperative->ward->ward_name_ne ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.village') }}:</strong>
                                    {{ $cooperative->village ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.tole') }}:</strong>
                                    {{ $cooperative->tole ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            </div>
                        </div>

                        @if (!empty($cooperative) && $cooperative->photo)
                            <div class="row mt-4">
                                <div class="col-md-6 offset-md-6">
                                    <div class="form-group">
                                        <h6 class="border-bottom pb-2 mt-4 mb-3">
                                            {{ __('grantmanagement::grantmanagement.photo') }}
                                        </h6>

                                        @php
                                            $extension = strtolower(pathinfo($cooperative->photo, PATHINFO_EXTENSION));
                                        @endphp

                                        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                            <img src="{{ customAsset(config('src.GrantManagement.grant.photo'), $cooperative->photo) }}"
                                                alt="{{ __('grantmanagement::grantmanagement.cooperative_photo') }}"
                                                class="img-thumbnail mt-2" style="height: 300px;">
                                        @elseif($extension === 'pdf')
                                            <div class="card mt-2" style="max-width: 200px;">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        {{ __('grantmanagement::grantmanagement.pdf_file') }}
                                                    </h5>
                                                    <p class="card-text">{{ $cooperative->photo }}</p>
                                                    <a href="{{ customFileAsset(config('src.GrantManagement.grant.photo'), $cooperative->photo) }}"
                                                        target="_blank" class="btn btn-primary btn-sm">
                                                        {{ __('grantmanagement::grantmanagement.open_pdf') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.cooperative.index') }}" class="btn btn-danger">
                            {{ __('grantmanagement::grantmanagement.back') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.app>
