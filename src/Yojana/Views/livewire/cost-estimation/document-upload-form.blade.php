<form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" wire:model="plan_id" />

    <div class="row">
        @foreach ($fields as $field)
            <?php
            $label = ucwords(str_replace('_', ' ', $field));
            $urlField = $field . '_Url';
            ?>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="{{ $field }}" class="form-label">{{ __($label) }}</label>
                    <input wire:model="{{ $field }}" name="{{ $field }}" type="file"
                        class="form-control">
                    <div>
                        @if ($$urlField)
                            <div class="row align-items-center mb-2 mt-2">
                                <div class="col">
                                    <strong>{{ __('yojana::yojana.preview') }}:</strong>
                                    <a href="{{ $$urlField }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm ms-2">
                                        <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm ms-2"
                                        wire:click="deleteFile('{{ $field }}')"
                                        wire:confirm="Are you sure you want to delete it??">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @endif
                        <div wire:loading wire:target="{{ $field }}">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Uploading...
                        </div>
                        @error($field)
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
    </div>



    {{-- <div class="mt-3">
        <button type="submit" class="btn btn-primary fw-bold">{{ __('yojana::yojana.submit') }}</button>
    </div> --}}

    @push('styles')
        <style>
            .field {
                font-size: 1rem;
                font-weight: 600;
                color: #222;
            }

            input[type="file"] {
                border-radius: 0.5rem;
            }
        </style>
    @endpush
</form>
