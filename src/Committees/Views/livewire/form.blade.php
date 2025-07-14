<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <x-form.select-input
                    label="{{__('Committee Types')}}"
                    id="committee_type_id"
                    name="committee.committee_type_id"
                    :options="\Src\Committees\Models\CommitteeType::get()->pluck('name', 'id')->toArray()"
                    placeholder="{{__('Choose Committee Types')}}" required
                />
            </div>
            <div class='col-md-6'>
                <x-form.text-input
                    label="{{__('Committee Name')}}"
                    id="committee_name"
                    name="committee.committee_name"
                    placeholder="{{__('Committee Name')}}"
                />
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('Save')}}</button>
        <a href="{{route('admin.committees.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('Back')}}</a>
    </div>
</form>
