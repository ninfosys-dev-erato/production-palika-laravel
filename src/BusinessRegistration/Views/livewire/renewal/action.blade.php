<div class="card">
    <div class="card-body">
        @php
            use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;
        @endphp
        @if ($businessRenewal->registration->data)
            @php
                $data = is_array($businessRenewal->registration->data)
                    ? $businessRenewal->registration->data
                    : json_decode($businessRenewal->registration->data, true);
            @endphp
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">
                {{ __('businessregistration::businessregistration.business_registration_details') }}</h4>
            <div class="d-flex">
                @if ($businessRenewal->application_status == Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING)
                    <div class="d-flex justify-content-start mt-3">
                        <button class="btn btn-primary" wire:click="$dispatch('showPaymentModal')">
                            <i class="bx bx-wallet-alt"></i>
                            {{ __('businessregistration::businessregistration.send_for_payment') }}
                        </button>
                    </div>
                @endif
                @if ($businessRenewal->application_status === Src\BusinessRegistration\Enums\ApplicationStatusEnum::BILL_UPLOADED)
                    <div class="d-flex justify-content-start mt-3">
                        <button class="btn btn-primary" wire:click="$dispatch('approveRenewal')">
                            <i class="bx bx-wallet-alt"></i>
                            {{ __('businessregistration::businessregistration.approve_renewal') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <dl class="row mb-0">
                {{-- For Business --}}


                @if ($businessRenewal->registration->registration_category == RegistrationCategoryEnum::BUSINESS->value)

                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.capital_investment') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->capital_investment ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.working_capital') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->working_capital ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.fixed_capital') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->fixed_capital ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.is_rented') }}</dt>
                    <dd class="col-sm-8">
                        {{ $businessRenewal->registration->is_rented ? __('businessregistration::businessregistration.yes') : __('businessregistration::businessregistration.no') }}
                    </dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.houseownername') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->houseownername ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.phone') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->phone ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.monthly_rent') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->monthly_rent ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.rentagreement') }}
                    </dt>
                    <dd class="col-sm-8">
                        @if ($businessRenewal->registration->rentagreement)
                            <a href="{{ asset('storage/' . $businessRenewal->registration->rentagreement) }}"
                                target="_blank">{{ __('businessregistration::businessregistration.view_uploaded_file') }}</a>
                        @else
                            -
                        @endif
                    </dd>
                @endif

                {{-- For Firm --}}
                @if ($businessRenewal->registration->registration_category == RegistrationCategoryEnum::FIRM->value)
                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.capital_investment') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->capital_investment ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.operation_date') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->operation_date ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.houseownername') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->houseownername ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.east') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->east ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.west') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->west ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.north') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->north ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.south') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->south ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.landplotnumber') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->landplotnumber ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.area') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->area ?? '-' }}</dd>
                @endif

                {{-- For Industry --}}
                @if ($businessRenewal->registration->registration_category == RegistrationCategoryEnum::INDUSTRY->value)
                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.capital_investment') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->capital_investment ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.fixed_capital') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->fixed_capital ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.working_capital') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->working_capital ?? '-' }}</dd>

                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.production_capacity') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->production_capacity ?? '-' }}</dd>

                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.required_manpower') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->required_manpower ?? '-' }}</dd>

                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.number_of_shifts') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->number_of_shifts ?? '-' }}</dd>

                    <dt class="col-sm-4">{{ __('businessregistration::businessregistration.operation_date') }}
                    </dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->operation_date ?? '-' }}</dd>
                @endif

                {{-- For Organization --}}
                @if ($businessRenewal->registration->registration_category == RegistrationCategoryEnum::ORGANIZATION->value)
                    <dt class="col-sm-4">
                        {{ __('businessregistration::businessregistration.financial_source') }}</dt>
                    <dd class="col-sm-8">{{ $businessRenewal->registration->financial_source ?? '-' }}</dd>
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



    <div class="modal fade" id="sendForPaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('businessregistration::businessregistration.payable_renew_amount') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="renew_amount"
                            class="form-label">{{ __('businessregistration::businessregistration.renew_amount') }}</label>
                        <input dusk="businessregistration-renew_amount-field" type="number" id="renew_amount"
                            class="form-control" wire:model="renew_amount">
                        @error('renew_amount')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="penalty_amount"
                            class="form-label">{{ __('businessregistration::businessregistration.penalty_amount') }}</label>
                        <input dusk="businessregistration-penalty_amount-field" type="number" id="penalty_amount"
                            class="form-control" wire:model="penalty_amount">
                        @error('penalty_amount')
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

    <div class="modal fade" id="approveRenewalForm" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('businessregistration::businessregistration.approve_renewal_form') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class='form-group' wire:ignore>
                            <label for='bill_no'
                                class="form-label">{{ __('businessregistration::businessregistration.bill_no') }}</label>
                            <input dusk="businessregistration-bill_no-field" wire:model='bill_no' name='bill_no'
                                type='text' class='form-control'
                                placeholder="{{ __('businessregistration::businessregistration.bill_no') }}"
                                id="bill_no">
                        </div>
                        @error('bill_no')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                    <div>
                        <div class='form-group' wire:ignore>
                            <label for='payment_receipt_date'
                                class="form-label">{{ __('businessregistration::businessregistration.payment_date') }}</label>
                            <input dusk="businessregistration-payment_receipt_date-field"
                                wire:model='payment_receipt_date' name='payment_receipt_date' type='text'
                                class='form-control nepali-date'
                                placeholder="{{ __('businessregistration::businessregistration.payment_date') }}"
                                id="payment_receipt_date">
                        </div>
                        @error('payment_receipt_date')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class='form-group' wire:ignore>
                            <label for='date_to_be_maintained'
                                class="form-label">{{ __('businessregistration::businessregistration.date_to_be_maintained') }}</label>
                            <input dusk="businessregistration-date_to_be_maintained-field"
                                wire:model='date_to_be_maintained' name='date_to_be_maintained' type='text'
                                class='form-control nepali-date'
                                placeholder="{{ __('businessregistration::businessregistration.date_to_be_maintained') }}"
                                id="date_to_be_maintained">
                        </div>
                        @error('date_to_be_maintained')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="approveRenewal">{{ __('businessregistration::businessregistration.approve_renewal_request') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@script
    <script>
        $wire.on('showPaymentModal', () => {
            $('#sendForPaymentModal').modal('show');
        })

        $wire.on('approveRenewal', () => {
            $('#approveRenewalForm').modal('show');
        })
    </script>
@endscript
