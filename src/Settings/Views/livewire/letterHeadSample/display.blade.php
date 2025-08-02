<div>
    <!-- Loading Indicator -->
    <div wire:loading class="text-center py-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="row" wire:loading.class="opacity-50">
        @forelse($letterHeads as $letterHead)
            <div class="col-sm-12 col-md-12 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">

                        <!-- Title and Slug -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('settings::settings.template_type') }}:</label>
                            <input type="text" class="form-control" value="{{ $letterHead->slug->label() }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('settings::settings.name') }}:</label>
                            <input type="text" class="form-control" value="{{ $letterHead->name }}" readonly>
                        </div>


                        <div class="border p-3 mt-3" style="background: #f9f9f9;">
                            <!-- Inject the style -->
                            <style>
                                {!! $letterHead->style !!}
                            </style>

                            <!-- Render the HTML content -->
                            {!! $letterHead->content !!}
                        </div>

                        <!-- Action buttons -->
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button wire:click="edit({{ $letterHead->id }})" class="btn btn-primary btn-sm">
                                <i class="bx bx-edit-alt"></i> {{ __('settings::settings.edit') }}
                            </button>
                            <button wire:click="delete({{ $letterHead->id }})" class="btn btn-danger btn-sm">
                                <i class="bx bx-trash"></i> {{ __('settings::settings.delete') }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bx bx-file-blank" style="font-size: 4rem; color: #dee2e6;"></i>
                    <h5 class="mt-3 text-muted">{{ __('settings::settings.no_letter_head_samples_found') }}</h5>
                    <p class="text-muted">{{ __('settings::settings.create_first_letter_head_sample') }}</p>
                </div>
            </div>
        @endforelse
    </div>




</div>
