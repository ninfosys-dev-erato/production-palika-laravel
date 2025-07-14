<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5><strong>{{__('yojana::yojana.subject__')}}</strong>{{__($model->subject)}}</h5>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="save">
                    <i class="bx bx-save"></i> {{ __('yojana::yojana.save') }}
                </button>
                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled"
                    wire:click="resetLetter">
                    <i class="bx bx-reset"></i> {{ __('yojana::yojana.reset') }}
                </button>
                <div class="d-flex align-items-center">
                    <label for="" class="mb-0">{{ __('yojana::yojana.edit_mode') }}&nbsp;</label>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" {{ !$preview ? 'checked' : '' }}
                            wire:click="togglePreview">
                    </div>
                </div>
            </div>

            <div>
                <button type="button" class="btn btn-outline-primary btn-info"
                    onclick="Livewire.dispatch('print-yojana-form')" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ __('yojana::yojana.print_form') }}">
                    <i class="bx bx-printer"></i> {{ __('yojana::yojana.print') }}
                </button>
            </div>

        </div>
    </div>

    <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
        <x-form.ck-editor-input label="" id="recommendation_letter" name="letter" :value="$letter" />
    </div>
    <div class="card mt-3 {{ !$preview ? 'd-none' : '' }}">
        <div class="card-body">
            <div class="col-md-12">
                {!! $letter !!}
            </div>
        </div>
    </div>


</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf-in-new-tab', (event) => {
                console.log(event);
                window.open(event.url, '_blank');
            });

            Livewire.on('refresh-page', (event) => {
                location.reload();
            });

        });

    </script>
@endpush
