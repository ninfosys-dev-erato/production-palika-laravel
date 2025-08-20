<div>
    <div class="my-4 p-3 bg-light border rounded shadow-sm">
        <strong class="text-primary">{{ __('Payable Amount') }}:</strong>
        <span class="fw-bold text-dark">{{ $businessRegistration->amount ?? __('Not Defined') }}</span>
    </div>
    @if ($showBillUpload)
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-lg p-4">
                <h5 class="text-center text-primary mb-3">{{ __('Upload Payment Photo') }}</h5>

                <form wire:submit.prevent="uploadBill">
                    <div class="mb-3">
                        <label for="bill" class="form-label fw-bold">{{ __('Payment Photo') }}</label>
                        <input wire:model="bill" name="bill" type="file" class="form-control" accept="image/*,application/pdf">
                        @error('bill')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($bill)
                        <div class="text-center">
                            <img src="{{ $bill->temporaryUrl() }}" alt="Uploaded Image Preview"
                                class="img-thumbnail mt-2 shadow" style="max-height: 300px; border-radius: 8px;">
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <button class="btn btn-primary px-4" type="submit" wire:loading.attr="disabled"
                            wire:click="uploadBill">
                            {{ __('Upload') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (isset($businessRegistration->bill))
        <div class="col-md-12 mb-3">
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">{{ __('Uploaded Payment') }}</h6>
                <button type="button" class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                    data-bs-target="#billPreviewModal">
                    {{ __('View') }}
                </button>
            </div>
            <iframe
                src="{{ customAsset(config('src.BusinessRegistrationAndRenewal.businessRegistration.bill'), $businessRegistration->bill, 'local') }}"
                frameborder="0"
                style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            </iframe>
        </div>
    @endif

    <div class="modal fade" id="billPreviewModal" tabindex="-1" role="dialog" aria-labelledby="billPreviewModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="billPreviewModalLabel">{{ __('Uploaded Payment Preview') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    @if ($businessRegistration->bill)
                        @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $businessRegistration->bill))
                            <img src="{{ customAsset(config('src.BusinessRegistrationAndRenewal.businessRegistration.bill'), $businessRegistration->bill, 'local') }}"
                                alt="Uploaded Payment" class="img-fluid rounded">
                        @else
                            <p>{{ __('No file uploaded.') }}</p>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
