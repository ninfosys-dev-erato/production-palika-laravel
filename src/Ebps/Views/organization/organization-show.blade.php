@php
    function getStatusColor($status)
    {
        switch (strtolower($status)) {
            case 'accepted':
                return 'bg-success text-white';
            case 'pending':
                return 'bg-warning text-dark';
            case 'rejected':
                return 'bg-danger text-white';
            default:
                return 'bg-secondary text-white';
        }
    }
    function getTextColor($status)
    {
        switch (strtolower($status)) {
            case 'accepted':
                return ' text-success';
            case 'pending':
                return ' text-warning';
            case 'rejected':
                return 'text-danger';
            default:
                return ' text-secondary';
        }
    }

@endphp

<x-layout.app header="Organization Detail">
    <div class="my-2">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-info" onclick="history.back()">
                    <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
                </button>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-lg h-80">
                    <div class="card-body bg-white text-center d-flex flex-column align-items-center"
                        style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">

                        @if ($organization->logo)
                            <img src="{{ customAsset(config('src.Ebps.ebps.path'), $organization->logo, 'local') }}"
                                alt="{{ $organization->org_name_en }}" class="rounded-circle border shadow mb-3"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @elseif($organization->org_name_en)
                            <img src="{{ Avatar::create($organization->org_name_en)->toBase64() }}"
                                alt="{{ $organization->org_name_en }}" class="rounded-circle border shadow mb-3"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @endif

                        <h4 class="fw-bold text-primary">{{ $organization->org_name_ne }}</h4>

                        @if ($organization->org_email)
                            <p class="mb-1">
                                <strong>{{ __('ebps::ebps.email') }}:</strong>
                                <a href="mailto:{{ $organization->org_email }}"
                                    class="text-decoration-none">{{ $organization->org_email }}</a>
                            </p>
                        @endif

                        <p class="mb-1">
                            <strong>{{ __('ebps::ebps.mobile') }}:</strong>
                            <a href="tel:{{ $organization->org_contact }}"
                                class="text-decoration-none">{{ $organization->org_contact }}</a>
                        </p>

                        <p class="mb-0">
                            <strong>{{ __('ebps::ebps.address') }}:</strong>
                            <br>
                            {{ ($organization->province->title ?? __('ebps::ebps.not_provided')) .
                                ', ' .
                                ($organization->dictrict->title ?? __('ebps::ebps.not_provided')) .
                                ', ' .
                                ($organization->localBody->title ?? __('ebps::ebps.not_provided')) .
                                ' - ' .
                                ($organization->ward ?? __('ebps::ebps.not_provided')) .
                                ', ' .
                                ($organization->temporary_tole ?? __('ebps::ebps.not_provided')) }}
                        </p>

                        <hr class="w-100 my-3">
                        <p class="mb-0">
                            <strong>{{ __('ebps::ebps.status') }}:</strong>
                            <span class="badge {{ getTextColor($organization?->status?->value) }}">
                                {{ strtoupper($organization?->status?->value) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-lg bg-light h-60 p-3 mb-3">
                    <strong>
                        <h5 lass="fw-bold text-primary mb-5">{{ __('ebps::ebps.organization_details') }}</h5>
                    </strong>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p><strong>{{ __('ebps::ebps.registration_number') }}:</strong>
                                {{ $organization->org_registration_no ?? __('ebps::ebps.not_provided') }}
                            </p>
                            <p><strong>{{ __('ebps::ebps.registration_date') }}:</strong>
                                {{ $organization->org_registration_date ?? __('ebps::ebps.not_provided') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>{{ __('ebps::ebps.pan_no') }}:</strong>
                                {{ $organization->org_pan_no ?? __('ebps::ebps.not_provided') }}
                            </p>
                            <p><strong>{{ __('ebps::ebps.pan_registration_date') }}:</strong>
                                {{ $organization->org_pan_registration_date ?? __('ebps::ebps.not_provided') }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>{{ __('ebps::ebps.local_body_registration_no') }}:</strong>
                                {{ $organization->local_body_registration_no ?? __('ebps::ebps.not_provided') }}
                            </p>
                            <p><strong>{{ __('ebps::ebps.local_body_registration_date') }}:</strong>
                                {{ $organization->local_body_registration_date ?? __('ebps::ebps.not_provided') }}
                            </p>
                        </div>
                    </div>

                </div>

                <div class="card shadow-sm border-0 rounded-lg bg-light h-30 p-4">
                    <div class="row">
                        @if ($organization?->status?->value !== 'accepted')
                            <div class="col-md-12">
                                <livewire:ebps.organization_change_status_form :organization="$organization" :action="\App\Enums\Action::UPDATE" />
                            </div>
                        @else
                            <div class="col-md-12 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="mb-2">
                                        {{ __('ebps::ebps.the_organization_is_active_you_may_choose_to_deactivate_it_below') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <form
                                        action="{{ route('admin.ebps.organizations.deactivate', $organization->id) }}"
                                        method="POST">
                                        @csrf
                                        @if ($organization->is_active)
                                            <button type="submit" class="btn btn-danger"
                                                wire:confirm='Are you sure you want to deactivate?'>
                                                {{ __('ebps::ebps.deactivate_organization') }}
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success"
                                                wire:confirm='Are you sure you want to activate?'>
                                                {{ __('ebps::ebps.activate_organization') }}
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-org-doc" aria-controls="navs-pills-org-doc" aria-selected="false">
                        {{ __('ebps::ebps.organization_document') }}
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-other" aria-controls="navs-pills-other" aria-selected="false">
                        {{ __('ebps::ebps.other_document') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-tax" aria-controls="navs-pills-logs" aria-selected="false">
                        {{ __('ebps::ebps.tax_clearance') }}
                    </button>
                </li>

            </ul>

        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-pills-org-doc" role="tabpanel">
                    <div class="card-01">
                        <div class="row">
                            <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 2px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>{{ __('ebps::ebps.organization_registration_document') }}:</strong><br>
                                        @if ($organization->org_registration_document)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImage('{{ customAsset(config('src.Ebps.ebps.path'), $organization->org_registration_document, 'local') }}')">
                                                <img src="{{ customAsset(config('src.Ebps.ebps.path'), $organization->org_registration_document, 'local') }}"
                                                    alt="" class="img-fluid" />
                                            </a>
                                        @else
                                            <p>{{ __('ebps::ebps.not_provided') }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <strong>{{ __('ebps::ebps.organization_pan_document') }}:</strong><br>
                                        @if ($organization->org_pan_document)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImage('{{ customAsset(config('src.Ebps.ebps.path'), $organization->org_pan_document, 'local') }}')">
                                                <img src="{{ customAsset(config('src.Ebps.ebps.path'), $organization->org_pan_document, 'local') }}"
                                                    alt="" class="img-fluid" />
                                            </a>
                                        @else
                                            <p>{{ __('ebps::ebps.not_provided') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="navs-pills-other" role="tabpanel">
                    <div class="card-01">
                        <div class="row">
                            <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 2px;">
                                <h5 class="text-center text-decoration-underline">
                                    {{ __('ebps::ebps.document_images') }}
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>{{ __('ebps::ebps.company_registration_document') }}:</strong><br>
                                        @if ($organization->company_registration_document)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImage('{{ customAsset(config('src.Ebps.ebps.path'), $organization->company_registration_document, 'local') }}')">
                                                <img src="{{ customAsset(config('src.Ebps.ebps.path'), $organization->company_registration_document, 'local') }}"
                                                    alt="" class="img-fluid" />
                                            </a>
                                        @else
                                            <p>{{ __('ebps::ebps.not_provided') }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <strong>{{ __('ebps::ebps.organization_pan_document') }}:</strong><br>
                                        @if ($organization->org_pan_document)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                onclick="showImage('{{ customAsset(config('src.Ebps.ebps.path'), $organization->org_pan_document, 'local') }}')">
                                                <img src="{{ customAsset(config('src.Ebps.ebps.path'), $organization->org_pan_document, 'local') }}"
                                                    alt="" class="img-fluid" />
                                            </a>
                                        @else
                                            <p>{{ __('ebps::ebps.not_provided') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-tax" role="tabpanel">
                    <div class="card-01">
                        <div class="row">
                            <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 2px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>{{ __('ebps::ebps.tax_document') }}:</strong><br>
                                        @if ($organization->taxClearances)
                                            @php
                                                $taxClearance = $organization->taxClearances->first();
                                            @endphp
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalTaxImage"
                                                onclick="showTaxImage('{{ customAsset(config('src.Ebps.ebps.path'), $taxClearance?->document, 'local') }}')">
                                                <img src="{{ customAsset(config('src.Ebps.ebps.path'), $taxClearance?->document, 'local') }}"
                                                    alt="" class="img-fluid" />
                                            </a>
                                        @else
                                            <p>{{ __('ebps::ebps.not_provided') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('ebps::ebps.document_image') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center align-items-center">
                                <img id="modalImage" src="" alt="Document Image" class="img-fluid"
                                    style="max-height: 100%; max-width: 100%;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalTaxImage" tabindex="-1" aria-labelledby="modalTaxImageLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('ebps::ebps.document_image') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center align-items-center">
                                <img id="modalTaxImg" src="" alt="Tax Document Image" class="img-fluid"
                                    style="max-height: 100%; max-width: 100%;" />
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function showImage(src) {
                        document.getElementById('modalImage').src = src;
                    }

                    function showTaxImage(src) {
                        document.getElementById('modalTaxImg').src = src;
                    }
                </script>
            </div>
        </div>
    </div>
</x-layout.app>
