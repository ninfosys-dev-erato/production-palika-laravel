<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='consumer_committee_id'>Consumer Committee Id</label>
                <input wire:model='consumerCommitteeOfficial.consumer_committee_id' name='consumer_committee_id' type='text' class='form-control' placeholder='Enter Consumer Committee Id'>
                <div>
                    @error('consumerCommitteeOfficial.consumer_committee_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='post'>Post</label>
                <input wire:model='consumerCommitteeOfficial.post' name='post' type='text' class='form-control' placeholder='Enter Post'>
                <div>
                    @error('consumerCommitteeOfficial.post')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='name'>Name</label>
                <input wire:model='consumerCommitteeOfficial.name' name='name' type='text' class='form-control' placeholder='Enter Name'>
                <div>
                    @error('consumerCommitteeOfficial.name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='father_name'>Father Name</label>
                <input wire:model='consumerCommitteeOfficial.father_name' name='father_name' type='text' class='form-control' placeholder='Enter Father Name'>
                <div>
                    @error('consumerCommitteeOfficial.father_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='grandfather_name'>Grandfather Name</label>
                <input wire:model='consumerCommitteeOfficial.grandfather_name' name='grandfather_name' type='text' class='form-control' placeholder='Enter Grandfather Name'>
                <div>
                    @error('consumerCommitteeOfficial.grandfather_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='address'>Address</label>
                <input wire:model='consumerCommitteeOfficial.address' name='address' type='text' class='form-control' placeholder='Enter Address'>
                <div>
                    @error('consumerCommitteeOfficial.address')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='gender'>Gender</label>
                <input wire:model='consumerCommitteeOfficial.gender' name='gender' type='text' class='form-control' placeholder='Enter Gender'>
                <div>
                    @error('consumerCommitteeOfficial.gender')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='phone'>Phone</label>
                <input wire:model='consumerCommitteeOfficial.phone' name='phone' type='text' class='form-control' placeholder='Enter Phone'>
                <div>
                    @error('consumerCommitteeOfficial.phone')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='citizenship_no'>Citizenship No</label>
                <input wire:model='consumerCommitteeOfficial.citizenship_no' name='citizenship_no' type='text' class='form-control' placeholder='Enter Citizenship No'>
                <div>
                    @error('consumerCommitteeOfficial.citizenship_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.consumer_committee_officials.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
