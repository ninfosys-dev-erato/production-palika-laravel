<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title'>{{ __('ebps::ebps.title') }}</label>
                    <input wire:model='constructionType.title' name='title' type='text' class='form-control'
                        placeholder="{{__('ebps::ebps.enter_title')}}">
                    <div>
                        @error('constructionType.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ebps::ebps.save')}}</button>
        <a href="{{ route('admin.ebps.construction_types.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('ebps::ebps.back')}}</a>
    </div>
</form>
