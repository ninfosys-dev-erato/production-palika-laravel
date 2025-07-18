<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='name'>{{__('ejalas::ejalas.ejalashpriotitytitle')}}</label>
        <input wire:model='priotity.name' name='name' type='text' class='form-control' placeholder="{{__('ejalas::ejalas.enter_priotity_name')}}">
        <div>
            @error('priotity.name')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div><div class='col-md-6'>
    <div class='form-group'>
        <label class="form-label" for='position'>{{__('ejalas::ejalas.ejalashpriotitytitlesign')}}</label>
        <input wire:model='priotity.position' name='position' type='text' class='form-control' placeholder="{{__('ejalas::ejalas.enter_priotity_sign')}}">
        <div>
            @error('priotity.position')
                <small class='text-danger'>{{ __($message) }}</small>
            @enderror
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ejalas::ejalas.save')}}</button>
        <a href="{{route('admin.ejalas.priotities.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('ejalas::ejalas.back')}}</a>
    </div>
</form>
