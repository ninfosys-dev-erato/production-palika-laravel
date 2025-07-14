<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <x-form.select-input
                    label="{{__('yojana::yojana.committee_types')}}"
                    id="committee_type_id"
                    name="committee.committee_type_id"
                    :options="\Src\Yojana\Models\CommitteeType::get()->pluck('name', 'id')->toArray()"
                    placeholder="{{__('yojana::yojana.choose_committee_types')}}" required
                />
            </div>
            <div class='col-md-6'>
                <x-form.text-input
                    label="{{__('yojana::yojana.committee_name')}}"
                    id="committee_name"
                    name="committee.committee_name"
                    placeholder="{{__('yojana::yojana.committee_name')}}"
                />
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.committees.index')}}" wire:loading.attr="disabled"
           class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
