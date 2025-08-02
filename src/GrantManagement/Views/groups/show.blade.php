<x-layout.app header="{{ __('grantmanagement::grantmanagement.group_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grantmanagement::grantmanagement.group') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grantmanagement::grantmanagement.show') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('grantmanagement::grantmanagement.group_list') }}
                        </h5>
                    </div>
                    <div>
                        @perm('gms_activity create')
                            <a href="{{ route('admin.groups.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('grantmanagement::grantmanagement.add_group') }}</a>
                        @endperm
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">
                                    {{ __('grantmanagement::grantmanagement.group_information') }}
                                </h6>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.unique_id') }}:</strong>
                                    {{ $group->unique_id ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.name') }}:</strong>
                                    {{ $group->name ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.vat_pan') }}:</strong>
                                    {{ $group->vat_pan ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.registration_date') }}:</strong>
                                    {{ $group->registration_date ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.monthly_meeting') }}:</strong>
                                    {{ $group->monthly_meeting ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3">
                                    {{ __('grantmanagement::grantmanagement.address') }}
                                </h6>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.registered_office') }}:</strong>
                                    {{ $group->registered_office ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.province') }}:</strong>
                                    {{ $group->province->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.district') }}:</strong>
                                    {{ $group->district->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.local_body') }}:</strong>
                                    {{ $group->localBody->title ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.ward_no') }}:</strong>
                                    {{ $group->ward->ward_name_ne ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.village') }}:</strong>
                                    {{ $group->village ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.tole') }}:</strong>
                                    {{ $group->tole ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            </div>
                        </div>

                        @if (!empty($group) && $group->involved_farmers_ids)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-3">Involved Farmers</h6>
                                    <div class="mb-3">
                                        @foreach (explode(',', $group->involved_farmers_ids) as $groupId)
                                            <span class="badge bg-info me-1">{{ $groupId }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('admin.groups.index') }}" class="btn btn-danger">
                            {{ __('grantmanagement::grantmanagement.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
