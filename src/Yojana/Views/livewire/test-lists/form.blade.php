<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label for='title'>{{__('yojana::yojana.title')}}</label>
        <input wire:model='testList.title' name='title' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_title')}}">
        <div>
            @error('testList.title')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label for='type'>{{__('yojana::yojana.type')}}</label>
        <input wire:model='testList.type' name='type' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_type')}}">
        <div>
            @error('testList.type')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6 m-2'>
    <div class='form-group'>
        <label for='is_for_agreement'>{{__('yojana::yojana.is_for_agreement')}}</label>
{{--        <input wire:model='testList.is_for_agreement' name='is_for_agreement' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_is_for_agreement')}}">--}}
        <input wire:model="isForAgreement" name="is_for_agreement" type="checkbox"
               class="form-check-input m-1"
               id="is_for_agreement">
        <div>
        <div>
            @error('isForAgreement')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.test_lists.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
