<div class="card shadow-sm p-3 mt-3">
    <div class="row">
        <div class="col-12 mb-3">
            @if ($businessRegistration->data)
                @php($data = is_array($businessRegistration->data) ? $businessRegistration->data : json_decode($businessRegistration->data, true))
                @foreach ($data as $key => $field)
                    <p>
                        <strong>{{ $field['label'] }}:</strong>
                        @if ($field['type'] === 'group' && isset($field['fields']))
                            @foreach ($field['fields'] as $subKey => $subField)
                                <p>
                                    <strong>{{ $subField['label'] }}:</strong>
                                    {{ $subField['value'] ?? '' }}
                                </p>
                            @endforeach
                        @elseif ($field['type'] === 'file')
                            @if (is_array($field['value']))
                                @foreach ($field['value'] as $index => $fileValue)
                                    <img width="50"
                                        src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $fileValue, 'local') }}"
                                        alt="" class="rounded shadow-sm cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#filePreviewModal{{ $key }}{{ $index }}">

                                    <div class="modal fade" id="filePreviewModal{{ $key }}{{ $index }}"
                                        tabindex="-1" role="dialog" wire:ignore.self>
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        {{ __('businessregistration::businessregistration.file_preview') }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $fileValue, 'local') }}"
                                                        alt="{{ __('businessregistration::businessregistration.file_preview') }}"
                                                        class="img-fluid rounded">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <img width="50"
                                    src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $field['value'], 'local') }}"
                                    alt="" class="rounded shadow-sm cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#filePreviewModal{{ $key }}">

                                <div class="modal fade" id="filePreviewModal{{ $key }}" tabindex="-1"
                                    role="dialog" wire:ignore.self>
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    {{ __('businessregistration::businessregistration.file_preview') }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $field['value'], 'local') }}"
                                                    alt="{{ __('businessregistration::businessregistration.file_preview') }}"
                                                    class="img-fluid rounded">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif ($field['type'] === 'table')
                            @if (array_key_exists('fields', $field))
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
                                                                @if (is_array($column['value']))
                                                                    @foreach ($column['value'] as $index => $fileValue)
                                                                        <img width="180" height="150"
                                                                            src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $fileValue, 'local') }}"
                                                                            alt=""
                                                                            class="rounded shadow-sm cursor-pointer"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#filePreviewModal{{ $key }}{{ $index }}">

                                                                        <div class="modal fade"
                                                                            id="filePreviewModal{{ $key }}{{ $index }}"
                                                                            tabindex="-1" role="dialog"
                                                                            wire:ignore.self>
                                                                            <div class="modal-dialog modal-lg"
                                                                                role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">
                                                                                            {{ __('businessregistration::businessregistration.file_preview') }}
                                                                                        </h5>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body text-center">
                                                                                        <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $fileValue, 'local') }}"
                                                                                            alt="{{ __('businessregistration::businessregistration.file_preview') }}"
                                                                                            class="img-fluid rounded">
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.close') }}</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <img width="180" height="150"
                                                                        src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $column['value'], 'local') }}"
                                                                        alt=""
                                                                        class="rounded shadow-sm cursor-pointer"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#filePreviewModal{{ $key }}">

                                                                    <div class="modal fade"
                                                                        id="filePreviewModal{{ $key }}"
                                                                        tabindex="-1" role="dialog" wire:ignore.self>
                                                                        <div class="modal-dialog modal-lg"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">
                                                                                        {{ __('businessregistration::businessregistration.file_preview') }}
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body text-center">
                                                                                    <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $column['value'], 'local') }}"
                                                                                        alt="{{ __('businessregistration::businessregistration.file_preview') }}"
                                                                                        class="img-fluid rounded">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.close') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
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
                            @endif
                        @else
                            {{ is_array($field['value']) ? implode(', ', $field['value']) : $field['value'] ?? __('businessregistration::businessregistration.no_value_provided') }}
                        @endif
                    </p>
                @endforeach
            @else
                <p class="text-muted">{{ __('businessregistration::businessregistration.no_data_available') }}</p>
            @endif
        </div>
    </div>

        @if ($businessRegistration->application_status === Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING->value)
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-primary" wire:click="$dispatch('showAmountModal')">
                    <i class="bx bx-wallet-alt"></i>
                    {{ __('businessregistration::businessregistration.send_for_payment') }}
                </button>
            </div>
        @endif

        @if (
            $businessRegistration->application_status ===
                Src\BusinessRegistration\Enums\ApplicationStatusEnum::BILL_UPLOADED->value)
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-success" wire:click="$dispatch('showApproveModal')"
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ __('businessregistration::businessregistration.approve') }}">
                    <i class="bx bx-checkbox-checked"></i> {{ __('businessregistration::businessregistration.approve') }}
                </button>
            </div>
        @endif

    {{-- Send for payment modal --}}
    <div class="modal fade" id="sendForPaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
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
        <div class="modal-dialog" role="document">
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
</div>

@push('scripts')
    <script>
        Livewire.on('showApproveModal', () => {
            $('#approveModal').modal('show');
        });

        Livewire.on('showAmountModal', () => {
            $('#sendForPaymentModal').modal('show');
        })
    </script>
@endpush
