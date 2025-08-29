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
                                    class="form-control" accept="image/*,application/pdf">

                                @error('payment_receipt')
                                    <div class="text-danger">{{ __($message) }}</div>
                                @enderror
                                @if ($payment_receipt)
                                    <a href="{{ $payment_receipt }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-file"></i>
                                        {{ __('yojana::yojana.view_uploaded_file') }}
                                    </a>
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
                @php
                    $fileUrl = customFileAsset(
                        config('src.BusinessRegistration.businessRegistration.bill'),
                        $businessRenewal->payment_receipt,
                        getStorageDisk('private'),
                        'tempUrl',
                    );
                @endphp

                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-file"></i>
                    {{ __('yojana::yojana.view_uploaded_file') }}
                </a>
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
                            <img src="{{ customFileAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessRenewal->payment_receipt, 'local', 'tempUrl') }}"
                                alt="Full-size Uploaded Bill" class="img-fluid" style="max-height: 90vh;">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
