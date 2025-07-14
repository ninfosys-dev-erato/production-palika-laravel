<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="save">
                <i class="bx bx-save"></i> {{ __('recommendation::recommendation.save') }}
            </button>
            <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="resetLetter">
                <i class="bx bx-reset"></i> {{ __('recommendation::recommendation.reset') }}
            </button>
            <div class="d-flex align-items-center">
                <label for="" class="mb-0">{{ __('recommendation::recommendation.edit_mode') }}&nbsp;</label>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" {{ !$preview ? 'checked' : '' }}
                        wire:click="togglePreview">
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
{{--        <x-form.ck-editor-input label="" id="recommendation_letter" name="letter" :value="$letter" />--}}
        <x-form.summernote-editor label="" id="recommendation_letter" name="letter" :value="$letter"/>
    </div>

    <div class="col-md-12 {{ !$preview ? 'd-none' : '' }}">
        {!! $letter . $styles !!}
    </div>
</div>
