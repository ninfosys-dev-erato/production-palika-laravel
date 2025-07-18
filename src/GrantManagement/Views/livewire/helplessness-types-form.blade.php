<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='helplessness_type' class='form-label'>{{__('grantmanagement::grantmanagement.helplessness_type')}}</label>
                    <input wire:model='helplessnessType.helplessness_type' name='helplessness_type' type='text'
                        class='form-control' placeholder="{{__('grantmanagement::grantmanagement.enter_helplessness_type')}}">
                    <div>
                        @error('helplessnessType.helplessness_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='helplessness_type_en' class='form-label'>{{__('grantmanagement::grantmanagement.helplessness_type_en')}}</label>
                    <input wire:model='helplessnessType.helplessness_type_en' name='helplessness_type_en' type='text'
                        class='form-control' placeholder="{{__(key: 'Enter Helplessness Type En')}}">
                    <div>
                        @error('helplessnessType.helplessness_type_en')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('grantmanagement::grantmanagement.save')}}</button>
        <a href="{{route('admin.helplessness_types.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('grantmanagement::grantmanagement.back')}}</a>
    </div>
</form>