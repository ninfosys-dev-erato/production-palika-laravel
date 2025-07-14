<form action="">
    <div class="form-group">
        <label for="status">{{ __('grievance::grievance.grievance_status') }}</label>
        <select
            id="status"
            name="grievanceDetail.status"
            class="form-control"
            wire:model="grievanceDetail.status"
            wire:change="setKycStatus($event.target.value)"
        >
            <option value="" hidden >{{ __('grievance::grievance.choose_status') }}</option>
            @foreach(\Src\Grievance\Enums\GrievanceStatusEnum::cases() as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>

    @if($grievanceDetail->status->value === 'investigating')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card-body border shadow-lg bg-light flex-fill" style="border-radius: 2px;">
                <div class="mb-3">
                    <p>{{__('grievance::grievance.select_investigation_type')}}</p>
                    @foreach ($investigationTypes as $type)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   value="{{ $type['id'] }}"
                                   id="type{{ $loop->index + 1 }}"
                                   wire:model.defer="selectedInvestigationTypes">
                            <label class="form-check-label" for="type{{ $loop->index + 1 }}">{{ $type['title'] ?? $type['title_en'] }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-3">
        <div class="col-md-12">
            <x-form.textarea-input
                label="{{__('grievance::grievance.suggestions')}}"
                id="suggestions"
                name="grievanceDetail.suggestions"
                wire:model.defer="suggestions"
                placeholder="Enter your suggestions here..."
                rows="4"
            />

            <div class="mb-3">
                <div class='form-group'>
                    <label for='image'>{{__('grievance::grievance.image')}}</label>
                    <input dusk="grievance-uploadedImage-field" wire:model="uploadedImage" name='uploadedImage' type='file' class='form-control' multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <div>
                        @error('uploadedImage')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                    @if($uploadedImage)
                        <div class="row">
                            @foreach($uploadedImage as $image)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Uploaded Image Preview" class="img-thumbnail w-100 " style="height: 150px; object-fit: cover;" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <button type="button" wire:confirm="Are you sure you want to change the grievance status?" wire:click="save" class="btn btn-primary">{{__('grievance::grievance.save')}}</button>
            </div>
        </div>
    </div>
</form>
