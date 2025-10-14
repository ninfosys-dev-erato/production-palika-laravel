<div>
    @php
        use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
        use Src\BusinessRegistration\Enums\BusinessRegistrationType;

        $data = is_array($businessRegistration->data)
            ? $businessRegistration->data
            : json_decode($businessRegistration->data, true);
    @endphp
    <div class="row mb-3">

        {{-- 1. Show all non-file fields first --}}
        <div class="card mb-4">
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-primary">
                    {{ __('businessregistration::businessregistration.business_registration_details') }}

                </h4>

                <div class="d-flex gap-2">
                    @perm('business_registration status')
                        @if ($businessRegistration->application_status != \Src\BusinessRegistration\Enums\ApplicationStatusEnum::REJECTED->value)
                            <button type="button" class="btn btn-danger" wire:click="$dispatch('showRejectModal')"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ __('businessregistration::businessregistration.reject') }}"
                                data-bs-target="#rejectModal">
                                <i class="bx bx-message-x"></i>
                                {{ __('businessregistration::businessregistration.reject') }}
                            </button>
                        @endif
                        @if ($businessRegistration->application_status === Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING->value)
                            <button class="btn btn-primary" wire:click="$dispatch('showAmountModal')"
                                data-bs-toggle="tooltip"
                                title="{{ __('businessregistration::businessregistration.send_for_payment') }}">
                                <i class="bx bx-wallet-alt me-1"></i>
                                {{ __('businessregistration::businessregistration.send_for_payment') }}
                            </button>
                        @endif
                        @if (
                            $businessRegistration->application_status ===
                                Src\BusinessRegistration\Enums\ApplicationStatusEnum::BILL_UPLOADED->value)
                            <button class="btn btn-success" wire:click="$dispatch('showApproveModal')"
                                data-bs-toggle="tooltip"
                                title="{{ __('businessregistration::businessregistration.approve') }}">
                                <i class="bx bx-checkbox-checked me-1"></i>
                                {{ __('businessregistration::businessregistration.approve') }}
                            </button>
                        @endif
                    @endperm
                </div>
            </div>
            <div class="card-body">

                <dl class="row mb-0">
                    {{-- For Business --}}
                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::BUSINESS->value)
                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.capital_investment') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->capital_investment ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.working_capital') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->working_capital ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.fixed_capital') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->fixed_capital ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.is_rented') }}</dt>
                        <dd class="col-sm-8">
                            {{ $businessRegistration->is_rented ? __('businessregistration::businessregistration.yes') : __('businessregistration::businessregistration.no') }}
                        </dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.houseownername') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->houseownername ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.phone') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->phone ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.monthly_rent') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->monthly_rent ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.rentagreement') }}
                        </dt>
                        <dd class="col-sm-8">
                            @if ($businessRegistration->rentagreement)
                                <a href="{{ App\Facades\FileFacade::getTemporaryUrl(
                                    path: config('src.BusinessRegistration.businessRegistration.registration'),
                                    filename: $businessRegistration->rentagreement,
                                    disk: getStorageDisk('private'),
                                ) }}"
                                    target="_blank">
                                    {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                </a>
                            @else
                                -
                            @endif
                        </dd>
                    @endif

                    {{-- For Firm --}}
                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::FIRM->value)
                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.capital_investment') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->capital_investment ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.operation_date') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->operation_date ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.houseownername') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->houseownername ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.east') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->east ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.west') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->west ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.north') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->north ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.south') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->south ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.landplotnumber') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->landplotnumber ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.area') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->area ?? '-' }}</dd>
                    @endif

                    {{-- For Industry --}}
                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::INDUSTRY->value)
                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.capital_investment') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->capital_investment ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.fixed_capital') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->fixed_capital ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.working_capital') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->working_capital ?? '-' }}</dd>

                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.production_capacity') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->production_capacity ?? '-' }}</dd>

                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.required_manpower') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->required_manpower ?? '-' }}</dd>

                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.number_of_shifts') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->number_of_shifts ?? '-' }}</dd>

                        <dt class="col-sm-4">{{ __('businessregistration::businessregistration.operation_date') }}
                        </dt>
                        <dd class="col-sm-8">{{ $businessRegistration->operation_date ?? '-' }}</dd>
                    @endif

                    {{-- For Organization --}}
                    @if ($businessRegistration->registration_category == RegistrationCategoryEnum::ORGANIZATION->value)
                        <dt class="col-sm-4">
                            {{ __('businessregistration::businessregistration.financial_source') }}</dt>
                        <dd class="col-sm-8">{{ $businessRegistration->financial_source ?? '-' }}</dd>
                    @endif
                </dl>

                <dl class="row mb-0">
                    @foreach ($data as $key => $field)
                        @if ($field['type'] !== 'file')
                            <dt class="col-sm-4 info-label fw-semibold">
                                {{ $field['label'] }}:
                            </dt>

                            @if ($field['type'] === 'group' && isset($field['fields']))
                                <dd class="col-sm-9">
                                    @foreach ($field['fields'] as $subField)
                                        <p>
                                            <strong>{{ $subField['label'] }}:</strong>
                                            {{ $subField['value'] ?? '' }}
                                        </p>
                                    @endforeach
                                </dd>
                            @elseif ($field['type'] === 'table' && isset($field['fields']))
                                <dd class="col-sm-9">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    @foreach ($field['fields'][0] as $headerField)
                                                        <th>{{ $headerField['label'] ?? ucfirst($headerField['key']) }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($field['fields'] as $row)
                                                    <tr>
                                                        @foreach ($row as $column)
                                                            <td>
                                                                @if ($column['type'] === 'file')
                                                                    {{-- Skip files here; we'll show files later --}}
                                                                    <em>File in table (will show below)</em>
                                                                @else
                                                                    {{ is_array($column['value']) ? implode(', ', $column['value']) : $column['value'] ?? 'N/A' }}
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </dd>
                            @else
                                <dd class="col-sm-8 info-value">
                                    {{ is_array($field['value']) ? implode(', ', $field['value']) : $field['value'] ?? __('businessregistration::businessregistration.no_value_provided') }}
                                </dd>
                            @endif
                        @endif
                    @endforeach
                </dl>
            </div>
        </div>

        {{-- 2. Show all files separately --}}
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="fw-bold text-primary">
                    {{ __('businessregistration::businessregistration.business_registration_files') }}</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    {{-- Citizenship Front --}}
                    @forelse ($businessRegistration->applicants as $index => $applicant)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                            <div class="border p-3 rounded  h-100">
                                <strong class="d-block mb-2 text-primary">
                                    {{ __('businessregistration::businessregistration.citizenship') }}
                                    ({{ $applicant->applicant_name }})
                                </strong>

                                @if (!empty($citizenshipFrontUrls[$index]))
                                    <a href="{{ $citizenshipFrontUrls[$index] }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-2">
                                        <i class="bx bx-file"></i>
                                        {{ __('businessregistration::businessregistration.citizenship_front') }}
                                    </a>
                                @else
                                    <span
                                        class="text-muted d-block mb-2">{{ __('businessregistration::businessregistration.no_front_file') }}</span>
                                @endif

                                @if (!empty($citizenshipRearUrls[$index]))
                                    <a href="{{ $citizenshipRearUrls[$index] }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bx bx-file"></i>
                                        {{ __('businessregistration::businessregistration.citizenship_rear') }}
                                    </a>
                                @else
                                    <span
                                        class="text-muted d-block">{{ __('businessregistration::businessregistration.no_rear_file') }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">
                                {{ __('businessregistration::businessregistration.no_applicants') }}</p>
                        </div>
                    @endforelse


                    @forelse ($businessRegistration->requiredBusinessDocs as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                            <div class="border p-3 rounded h-100">
                                <strong class="d-block mb-2 text-primary">
                                    {{ $item->document_label_ne }}
                                </strong>

                                @if (!empty($businessRequiredDocUrls[$item->id]))
                                    <a href="{{ $businessRequiredDocUrls[$item->id] }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bx bx-file"></i>
                                        {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                    </a>
                                @else
                                    <span class="text-muted d-block mt-2">No file available</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">
                                {{ __('businessregistration::businessregistration.no_required_documents_uploaded') }}
                            </p>
                        </div>
                    @endforelse

                    @foreach ($data as $key => $field)
                        @if ($field['type'] === 'file')
                            @php
                                $files = is_array($field['value']) ? $field['value'] : [$field['value']];
                                $urls = $dynamicFileUrls[$key] ?? [];
                            @endphp

                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                <div class="border p-3 rounded h-100">
                                    <strong
                                        class="d-block mb-2 text-primary">{{ $field['label_ne'] ?? $field['label'] }}</strong>



                                    @foreach ($files as $index => $fileValue)
                                        @if (!empty($urls[$index]))
                                            <a href="{{ $urls[$index] }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-2">
                                                <i class="bx bx-file"></i>
                                                {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach





                </div>
            </div>
        </div>

    </div>

    {{-- Send for payment modal --}}
    <div class="modal fade" id="sendForPaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('businessregistration::businessregistration.payable_amount') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount"
                            class="form-label">{{ __('businessregistration::businessregistration.required_amount') }}</label>
                        <input dusk="businessregistration-amount-field" type="text" id="amount"
                            class="form-control" wire:model="amount">
                        @error('amount')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="sendForPayment">{{ __('businessregistration::businessregistration.send_for_payment') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('businessregistration::businessregistration.approval_details') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bill_no"
                            class="form-label">{{ __('businessregistration::businessregistration.bill_number') }}</label>
                        <input dusk="businessregistration-bill_no-field" type="text" id="bill_no"
                            class="form-control" wire:model="bill_no">
                        @error('bill_no')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bill_no"
                            class="form-label">{{ __('businessregistration::businessregistration.signee_name') }}</label>
                        <input type="text" id="signee_name"
                            class="form-control" wire:model="signee_name">
                        @error('bill_no')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="approve">{{ __('businessregistration::businessregistration.save_and_approve') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- reject modal  --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('businessregistration::businessregistration.rejection_reason') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea dusk="businessregistration-rejectionReason-field" wire:model="rejectionReason" class="form-control"
                            rows="4"></textarea>
                        @error('rejectionReason')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.cancel') }}</button>
                    <button type="button" class="btn btn-danger"
                        wire:click="reject">{{ __('businessregistration::businessregistration.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- universal modal --}}
    <div class="modal fade" id="universalImageModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="universalImageTitle">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="universalImagePreview" src="" class="img-fluid rounded shadow-sm"
                        alt="Preview">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalImage = document.getElementById('universalImagePreview');
            const modalTitle = document.getElementById('universalImageTitle');

            document.querySelectorAll('.preview-image').forEach(img => {
                img.addEventListener('click', function() {
                    modalImage.src = this.dataset.image;
                    modalTitle.textContent = this.dataset.title || 'File Preview';
                });
            });
        });
    </script>


</div>

@push('scripts')
    <script>
        Livewire.on('showApproveModal', () => {
            $('#approveModal').modal('show');
        });

        Livewire.on('showAmountModal', () => {
            $('#sendForPaymentModal').modal('show');
        });
        Livewire.on('showRejectModal', () => {
            $('#rejectModal').modal('show');
        });
    </script>
@endpush
