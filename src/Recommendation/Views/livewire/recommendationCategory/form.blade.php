<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="title" class="form-label">
                            {{ __('recommendation::recommendation.title') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="title" name="recommendationCategory.title" dusk="title"
                            wire:model="recommendationCategory.title"
                            class="form-control @error('recommendationCategory.title') is-invalid @enderror"
                            placeholder="{{ __('recommendation::recommendation.title') }}">

                        @error('recommendationCategory.title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('recommendation::recommendation.save') }}</button>
        <a href="{{ route('admin.recommendations.recommendation-category.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('recommendation::recommendation.back') }}</a>
    </div>
</form>
