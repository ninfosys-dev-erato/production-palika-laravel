<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group form-label'>
                    <label class="form-label" for='title'>{{__('ejalas::ejalas.ejalashdisputeareatitle')}}</label>
                    <input wire:model='disputeArea.title' name='title' type='text' class='form-control'
                        placeholder="{{__('ejalas::ejalas.enter_dispute_title')}}">
                    <div>
                        @error('disputeArea.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group form-label'>
                    <label class="form-label" for='title_en'>{{__('ejalas::ejalas.ejalashdisputeareatitleen')}}</label>
                    <input wire:model='disputeArea.title_en' name='title_en' type='text' class='form-control'
                        placeholder="{{__('ejalas::ejalas.enter_dispute_title_en')}}">
                    <div>
                        @error('disputeArea.title_en')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ejalas::ejalas.save')}}</button>
        <a href="{{route('admin.ejalas.dispute_areas.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('ejalas::ejalas.back')}}</a>
    </div>
</form>