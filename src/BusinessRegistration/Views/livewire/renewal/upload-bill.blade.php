<div class="card">
    <div class="card-body">
        <div class="p-3 bg-light border rounded shadow-sm">
            <strong class="text-primary">{{ __('businessregistration::businessregistration.payable_amount') }}:</strong>
            <span
                class="fw-bold text-dark">{{ number_format($businessRenewal->renew_amount + ($businessRenewal->penalty_amount ?? 0), 2) ?? __('businessregistration::businessregistration.not_defined') }}</span>
        </div>
        @if ($showBillUpload)
            <div class="col-md-12 mb-2">
                <form wire:submit.prevent="uploadBill">
                    <div class="row">
                        <div class="col-md-12">

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
                    alt="Uploaded Bill Image" class="img-thumbnail mt-2 clickable"
                    style="height: 300px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#billModal">
            </div>

            <div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="billModalLabel">
                                {{ __('businessregistration::businessregistration.uploaded_bill_image') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessRenewal->payment_receipt, 'local') }}"
                                alt="Full-size Uploaded Bill" class="img-fluid" style="max-height: 90vh;">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
