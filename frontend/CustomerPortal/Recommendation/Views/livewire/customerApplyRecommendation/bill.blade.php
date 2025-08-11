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
                <h5 class="mb-0 fw-bold">{{ __('recommendation::recommendation.uploaded_payment') }}</h6>
                @php
                    $fileUrl = customFileAsset(
                        config('src.Recommendation.recommendation.bill'),
                        $applyRecommendation->bill,
                        'local',
                        'tempUrl',
                    );
                @endphp
                <!-- <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-light text-primary">
                    {{ __('recommendation::recommendation.view') }}
                </a> -->
                @if ($applyRecommendation->status == Src\Recommendation\Enums\RecommendationStatusEnum::BILL_UPLOADED)
                <div class="d-flex justify-content-end mt-2 mb-2">
                    <button class="btn btn-primary" wire:click="sendToApprover">{{ __('recommendation::recommendation.send_for_approval') }}</button>
                </div>
            @endif
            </div>
            <div class="card-body text-start p-3">
                @php
                    $extension = strtolower(pathinfo($applyRecommendation->bill, PATHINFO_EXTENSION));
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                    $isImage = in_array($extension, $imageExtensions);
                @endphp

                @if ($isImage)
                    <div class="card d-inline-block me-2 mb-2 cursor-pointer" style="width: 200px;"
                        data-bs-toggle="modal" data-bs-target="#billPreviewModal">
                        <div class="card-body text-center p-2">
                            <img src="{{ $fileUrl }}" alt="Bill Preview"
                                class="img-fluid rounded mb-2" style="max-height: 120px;">
                            <div class="text-muted small">Payment Image</div>
                            <div class="text-truncate small">{{ basename($applyRecommendation->bill) }}</div>
                        </div>
                    </div>

                    <!-- Modal for Image Preview -->
                    <div class="modal fade" id="billPreviewModal" tabindex="-1" role="dialog" wire:ignore.self>
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Payment Preview') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ $fileUrl }}" alt="{{ __('Payment Preview') }}" class="img-fluid rounded">
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary">{{ __('Open in New Tab') }}</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card d-inline-block me-2 mb-2" style="width: 200px;">
                        <div class="card-body text-center p-2">
                            <div class="text-muted" style="font-size: 14px;">
                                {{ strtoupper($extension) }} File
                            </div>
                            <div class="text-truncate small">{{ basename($applyRecommendation->bill) }}</div>
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-primary mt-2">{{ __('Open') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

  
</div>
