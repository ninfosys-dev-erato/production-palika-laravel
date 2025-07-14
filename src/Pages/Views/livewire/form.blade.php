<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title'>{{ __('pages::pages.title') }}</label>
                    <input wire:model='page.title' name='title' dusk='title' type='text' class='form-control'
                        placeholder="{{ __('pages::pages.enter_title') }}">
                    <div>
                        @error('page.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='slug'>{{ __('pages::pages.slug') }}</label>
                    <input wire:model='page.slug' name='slug' dusk='slug' type='text' class='form-control'
                        placeholder="{{ __('pages::pages.enter_slug') }}"
                        @if ($action === \App\Enums\Action::UPDATE) readonly @endif>
                    <div>
                        @error('page.slug')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-4">
            <div class='col-md-12'>
                <x-form.ck-editor-form-input dusk="pages-page.content-field" label="{{ __('pages::pages.content') }}" id="content" name="page.content"
                    :value="$page->content">
                </x-form.ck-editor-form-input>
            </div>
        </div>
        <div class="d-flex mt-3 gap-2">
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('pages::pages.save') }}</button>
            <a href="{{ route('admin.pages.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('pages::pages.back') }}</a>
        </div>
    </div>
</form>
