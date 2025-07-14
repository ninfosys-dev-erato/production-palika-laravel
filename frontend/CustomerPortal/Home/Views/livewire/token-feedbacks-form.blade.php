<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <!-- Token Number Field -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="token_id" class="form-label">{{ __('Token Number') }}</label>
                            <input wire:model="tokenNumber" name="tokenNumber" type="text" class="form-control"
                                placeholder="{{ __('Enter Token Number') }}">
                            <div>
                                @error('tokenNumber')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Token Date Field -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tokenDate" class="form-label">{{ __('Token Date') }}</label>
                            <input wire:model="tokenDate" name="tokenDate" type="date" class="form-control"
                                placeholder="{{ __('Enter Token Date') }}">
                            <div>
                                @error('tokenDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Number Field -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mobileNumber" class="form-label">{{ __('Mobile Number') }}</label>
                            <input wire:model="mobileNumber" name="mobileNumber" type="text" class="form-control"
                                placeholder="{{ __('Enter Mobile Number') }}">
                            <div>
                                @error('mobileNumber')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Find Button -->
                    <div class="col-md-2 mt-4">
                        <div class="form-group">
                            <button class="btn btn-success w-100 find-button" type="button" wire:click="findToken">
                                <i class="bx bx-search-alt-2"></i> {{ __('Find') }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Find Button -->
            <div class="col-md-12 {{ $preview ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body bg-light rounded">
                                <h5 class="mb-3 text-primary">{{ __('Token Holder Details') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label fw-semibold">{{ __('Name') }}</label>
                                        <div class="form-control-plaintext">
                                            {{ $registerToken?->tokenHolder?->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label fw-semibold">{{ __('Address') }}</label>
                                        <div class="form-control-plaintext">
                                            {{ $registerToken?->tokenHolder?->address ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="feedback" class="form-label">{{ __('Service Quality') }}</label>
                            <select name="service_quality" id="" class="form-select"
                                wire:model="tokenFeedback.service_quality">
                                <option value="" hidden>{{ __('Select an option') }}</option>
                                @foreach ($serviceQuality as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('tokenFeedback.service_quality')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="feedback" class="form-label">{{ __('Service Accesibility') }}</label>
                            <select name="service_accesibility" id="" class="form-select"
                                wire:model="tokenFeedback.service_accesibility">
                                <option value="" hidden>{{ __('Select an option') }}</option>
                                @foreach ($serviceAccesibilty as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('tokenFeedback.service_accesibility')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="feedback" class="form-label">{{ __('Citizen Satisfaction') }}</label>
                            <select name="citizen_satisfaction" id="" class="form-select"
                                wire:model="tokenFeedback.citizen_satisfaction">
                                <option value="" hidden>{{ __('Select an option') }}</option>
                                @foreach ($citizenSatisfaction as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('tokenFeedback.citizen_satisfaction')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="rating" class="form-label">{{ __('Rating') }}</label>
                            <input wire:model="tokenFeedback.rating" name="rating" type="text" class="form-control" placeholder="{{ __('Enter Rating') }}">
                            <div>
                                @error('tokenFeedback.rating')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer mt-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
        <a href="{{ route('admin.token_feedbacks.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('Back') }}</a>
    </div>
</form>
