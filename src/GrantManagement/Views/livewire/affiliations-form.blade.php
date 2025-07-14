<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title' class='form-label'>{{__('grantmanagement::grantmanagement.title')}}</label>
                    <input wire:model='affiliation.title' name='title' type='text' class='form-control'
                        placeholder="{{__('grantmanagement::grantmanagement.enter_title')}}">
                    <div>
                        @error('affiliation.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title_en' class='form-label'>{{__('grantmanagement::grantmanagement.title_en')}}</label>
                    <input wire:model='affiliation.title_en' name='title_en' type='text' class='form-control'
                        placeholder="{{__('grantmanagement::grantmanagement.enter_title_en')}}">
                    <div>
                        @error('affiliation.title_en')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{__('grantmanagement::grantmanagement.save')}}</button>
        <a href="{{route('admin.affiliations.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('grantmanagement::grantmanagement.back')}}</a>
    </div>
</form>