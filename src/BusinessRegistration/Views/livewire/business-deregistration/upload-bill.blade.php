<div>
    <div class="mt-4 p-3 bg-light border">
        <strong class="text-primary">{{ __('businessregistration::businessregistration.payable_amount') }}:</strong>
        <span
            class="fw-bold text-dark">{{ $businessDeRegistration->amount ?? __('businessregistration::businessregistration.not_defined') }}</span>
    </div>
    @if ($showBillUpload)
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-lg p-4">
                <h5 class="text-center text-primary mb-3">
                    {{ __('businessregistration::businessregistration.upload_payment_photo') }}</h5>

                <form wire:submit.prevent="uploadBill">
                    <div class="mb-3">
                        <label for="bill"
                            class="form-label fw-bold">{{ __('businessregistration::businessregistration.payment_photo') }}</label>
                        <input wire:model="bill" name="bill" type="file" class="form-control" accept="image/*">
                        @error('bill')
                            <div class="text-danger mt-1">{{ __($message) }}</div>
                        @enderror
                    </div>

                    @if ($bill)
                        <div class="text-center">
                            <img src="{{ $bill?->temporaryUrl() }}" alt="Uploaded Image Preview"
                                class="img-thumbnail mt-2 shadow" style="max-height: 300px; border-radius: 8px;">
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <button class="btn btn-primary px-4" type="submit" wire:loading.attr="disabled"
                            wire:click="uploadBill">
                            {{ __('businessregistration::businessregistration.upload') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (!empty($businessDeRegistration->bill))
        <div class="col-12 mb-4 bg-light border">

            <div class=" text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    {{ __('businessregistration::businessregistration.uploaded_payment') }}
                </h6>
                <button type="button" class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                    data-bs-target="#billPreviewModal">
                    {{ __('businessregistration::businessregistration.view') }}
                </button>
            </div>

            <div class="text-center">
                <img src="{{ customFileAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessDeRegistration->bill, 'local', 'tempUrl') }}"
                    alt="Uploaded Bill" class="img-fluid rounded shadow-sm border"
                    style="max-height: 300px; object-fit: contain;">
            </div>
        </div>
    @endif


    <div class="modal fade" id="billPreviewModal" tabindex="-1" role="dialog" aria-labelledby="billPreviewModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="billPreviewModalLabel">
                        {{ __('businessregistration::businessregistration.uploaded_payment_preview') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    @if ($businessDeRegistration->bill)
                        @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $businessDeRegistration->bill))
                            <img src="{{ customFileAsset(config('src.BusinessRegistration.businessRegistration.bill'), $businessDeRegistration->bill, 'local', 'tempUrl') }}"
                                alt="Uploaded Payment" class="img-fluid rounded">
                        @else
                            <p>{{ __('businessregistration::businessregistration.no_file_uploaded') }}</p>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('businessregistration::businessregistration.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
