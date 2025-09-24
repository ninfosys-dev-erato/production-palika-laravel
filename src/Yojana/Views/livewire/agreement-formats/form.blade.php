<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='implementation_method_id'>{{ __('yojana::yojana.implementation_method') }}</label>
                    <select wire:model='agreementFormat.implementation_method_id' name='implementation_method_id'
                        class='form-control'>
                        <option value="" hidden>{{ __('yojana::yojana.select_an_implementation_method') }}</option>
                        @foreach ($implementationMethod as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='agreementFormat.implementation_method_id' name='implementation_method_id'
                        type='text' class='form-control' placeholder="{{ __('yojana::yojana.enter_implementation_method_id') }}"> --}}
                    <div>
                        @error('agreementFormat.implementation_method_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='name'>{{ __('yojana::yojana.name') }}</label>
                    <input wire:model='agreementFormat.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_name') }}">
                    <div>
                        @error('agreementFormat.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12 mt-4'>
                <div class="container py-4">
                    @foreach($groupedBindings as $model => $variables)
                        <div class="mb-4">
                            @if ($model == 'no_dot')
                                <div class="mb-4">
                                    <h5 class="fw-bold">{{__('yojana::yojana.primary')}}</h5>
                                    @foreach($variables as $variable)
                                        <button class="btn btn-info btn-sm mb-2"
                                                data-bs-copiable="{{$variable}}"
                                                data-bs-title="{{$variable}}"
                                                type="button"
                                                style="border-radius: 8px; padding: 10px 20px;">
                                            <strong>{{ $variable }}</strong>
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="mb-4">
                                    <p class="fw-bold">{{ ucfirst($model) }}</p>
                                    @foreach($variables as $variable)
                                        <button class="btn btn-info btn-sm mb-2"
                                                data-bs-copiable="{{$variable}}"
                                                data-bs-title="{{$variable}}"
                                                type="button"
                                                style="border-radius: 8px; padding: 10px 20px;">
                                            <strong>{{ $variable }}</strong>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class='form-group'>
                    <x-form.ck-editor-input label="{{ __('yojana::yojana.sample_letter') }}"
                        id="agreement_format_description" name='agreementFormat.sample_letter' :value="$agreementFormat?->sample_letter ?? ''" />
                    <div>
                        @error('agreementFormat.sample_letter')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-12 mt-3'>
                <div class='form-group'>
                    <label class="form-label" for='style'>{{ __('yojana::yojana.style') }}</label>
                    <textarea wire:model="agreementFormat.styles" name="styles" class="form-control"
                        placeholder="{{ __('yojana::yojana.enter_style') }}" rows="5"></textarea>

                    <div>
                        @error('letterSample.styles')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a href="{{ route('admin.agreement_formats.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>

    </div>
</form>
@once
    @push('scripts')
        <script src="{{ asset('assets/js/copiable.js') }}"></script>
    @endpush
@endonce
