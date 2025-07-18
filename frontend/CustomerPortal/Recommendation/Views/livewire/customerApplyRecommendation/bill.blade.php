<div>
    @if ($showBillUpload)
        <div class="col-md-12 mb-2">

            <form wire:submit.prevent="uploadBill">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bill">{{ __('recommendation::recommendation.payment_photo') }}</label>
                            <input wire:model="bill" name="bill" type="file" class="form-control" accept="image/*">
                            @error('bill')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if ($bill)
                                <img src="{{ $bill->temporaryUrl() }}" alt="Uploaded Image Preview"
                                    class="img-thumbnail mt-2" style="height: 300px;">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-form.text-input :label="__('recommendation::recommendation.ltax_ebp_code')" id="ltax_ebp_code" name="ltax_ebp_code" />
                    </div>
                </div>
                <button class="btn btn-primary mt-2" type="submit" wire:loading.attr="disabled"
                    wire:click="uploadBill">{{ __('recommendation::recommendation.upload') }}</button>
            </form>

        </div>
    @endif

    @if (!empty($applyRecommendation->bill))
        <div class="col-md-12 mb-3">
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">{{ __('recommendation::recommendation.uploaded_payment') }}</h6>
                <a href="{{ customAsset(config('src.Recommendation.recommendation.bill'), $applyRecommendation->bill, 'local') }}"
                    class="btn btn-sm btn-light text-primary">
                    {{ __('recommendation::recommendation.view') }}
                </a>
            </div>
            <div class="card-body text-center p-3">
                <iframe
                    src="{{ customAsset(config('src.Recommendation.recommendation.bill'), $applyRecommendation->bill, 'local') }}"
                    frameborder="0"
                    style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                </iframe>
            </div>
        </div>
    @endif

    @if ($applyRecommendation->status == Src\Recommendation\Enums\RecommendationStatusEnum::BILL_UPLOADED)
        <div class="d-flex justify-content-end mt-2 mb-2">
            <button class="btn btn-primary" wire:click="sendToApprover">{{ __('recommendation::recommendation.send_for_approval') }}</button>
        </div>
    @endif
</div>
