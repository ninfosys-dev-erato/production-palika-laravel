<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='title'>{{__('ejalas::ejalas.ejalaslevelname')}}</label>
        <input wire:model='level.title' name='title' type='text' class='form-control' placeholder="{{__('ejalas::ejalas.enter_level')}}">
        <div>
            @error('level.title')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='title_en'>{{__('ejalas::ejalas.ejalaslevelnameen')}}</label>
        <input wire:model='level.title_en' name='title_en' type='text' class='form-control' placeholder="{{__('ejalas::ejalas.enter_level_en')}}">
        <div>
            @error('level.title_en')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ejalas::ejalas.save')}}</button>
        <a href="{{route('admin.ejalas.levels.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('ejalas::ejalas.back')}}</a>
    </div>
</form>
