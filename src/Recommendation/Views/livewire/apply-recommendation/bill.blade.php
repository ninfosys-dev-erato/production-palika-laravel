<div>
    @if ($showBillUpload)
        <div class="col-md-12 mb-2">

            <form wire:submit.prevent="uploadBill">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bill">{{ __('recommendation::recommendation.payment_photo') }}</label>
                            <input wire:model="bill" name="bill" type="file" class="form-control"
                                accept="image/*,.pdf">
                            @error('bill')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
   
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
                <!-- <a href="{{ customAsset(config('src.Recommendation.recommendation.bill'), $applyRecommendation->bill, 'local') }}"
                    class="btn btn-sm btn-secondary">
                    <i class="bx bx-show-alt"></i>
                    {{ __('recommendation::recommendation.view') }}
                </a> -->
            </div>
            <div class="card-body text-center p-3">
                {{-- <iframe
                    src="{{ customFileAsset(config('src.Recommendation.recommendation.bill'), $applyRecommendation->bill, 'local', 'tempUrl') }}"
                    frameborder="0"
                    style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                </iframe> --}}

                @if ($applyRecommendation->bill)
                    @php
                        $fileUrl = customFileAsset(
                            config('src.Recommendation.recommendation.bill'),
                            $applyRecommendation->bill,
                            'local',
                            'tempUrl',
                        );
                    @endphp

                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-file"></i>
                        {{ __('yojana::yojana.view_uploaded_file') }}
                    </a>
                @endif
            </div>
        </div>
    @endif

</div>
