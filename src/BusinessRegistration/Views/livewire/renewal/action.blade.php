<div>

    @if ($businessRenewal->application_status === Src\BusinessRegistration\Enums\ApplicationStatusEnum::PENDING)
        <div class="d-flex justify-content-start mt-3">
            <button class="btn btn-primary" wire:click="$dispatch('showPaymentModal')">
                <i class="bx bx-wallet-alt"></i> {{ __('businessregistration::businessregistration.send_for_payment') }}
            </button>
        </div>
    @endif


    @if ($showBillUpload)
        <div class="col-md-12 mb-2">
            <form wire:submit.prevent="uploadBill">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <h5>
                                {{ __('businessregistration::businessregistration.amount_to_be_paid') }} :
                                <span class="text-primary">
                                    {{ __('businessregistration::businessregistration.nrs') }}{{ number_format($businessRenewal->renew_amount + ($businessRenewal->penalty_amount ?? 0), 2) }}
                                </span>
                            </h5>
                        </div>
                        <div class="form-group">
                            <label
                                for="payment_receipt">{{ __('businessregistration::businessregistration.upload_payment_photo') }}</label>
                            <input wire:model="payment_receipt" name="payment_receipt" type="file"
                                class="form-control" accept="image/*">
                            @error('payment_receipt')
                                <div class="text-danger">{{ __($message) }}</div>
                            @enderror
                            @if ($payment_receipt)
                                <img src="{{ method_exists($payment_receipt, 'temporaryUrl') ? $payment_receipt->temporaryUrl() : $payment_receipt }}"
                                    alt="Uploaded Image Preview" class="img-thumbnail mt-2" style="height: 300px;"
                                    onerror="this.style.display='none';">
                            @endif

                        </div>
                    </div>
                </div>
                <button class="btn btn-primary mt-2" type="submit" wire:loading.attr="disabled"
                    wire:click="uploadBill">{{ __('businessregistration::businessregistration.upload') }}</button>
            </form>
        </div>
    @endif


    @if (!empty($businessRenewal->payment_receipt))
        <div class="col-md-12 mt-3">
            <label
                for="existing-bill">{{ __('businessregistration::businessregistration.uploaded_payment_photo') }}</label>
            <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessRenewal->payment_receipt, 'local') }}"
                alt="Uploaded Bill Image" class="img-thumbnail mt-2 clickable" style="height: 300px; cursor: pointer;"
                data-bs-toggle="modal" data-bs-target="#billModal">
        </div>

        <div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="billModalLabel">
                            {{ __('businessregistration::businessregistration.uploaded_bill_image') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessRenewal->payment_receipt, 'local') }}"
                            alt="Full-size Uploaded Bill" class="img-fluid" style="max-height: 90vh;">
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($businessRenewal->application_status === Src\BusinessRegistration\Enums\ApplicationStatusEnum::BILL_UPLOADED)
        <div class="d-flex justify-content-start mt-3">
            <button class="btn btn-primary" wire:click="$dispatch('approveRenewal')">
                <i class="bx bx-wallet-alt"></i> {{ __('businessregistration::businessregistration.approve_renewal') }}
            </button>
        </div>
    @endif

    <div class="modal fade" id="sendForPaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('businessregistration::businessregistration.payable_renew_amount') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="renew_amount"
                            class="form-label">{{ __('businessregistration::businessregistration.renew_amount') }}</label>
                        <input dusk="businessregistration-renew_amount-field" type="text" id="renew_amount"
                            class="form-control" wire:model="renew_amount">
                        @error('renew_amount')
                            <span class="text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="penalty_amount"
                            class="form-label">{{ __('businessregistration::businessregistration.penalty_amount') }}</label>
                        <input dusk="businessregistration-penalty_amount-field" type="text" id="penalty_amount"
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
        <div class="modal-dialog" role="document">
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
