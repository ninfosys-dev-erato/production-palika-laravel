<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='benefitedMemberDetail.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('benefitedMemberDetail.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='ward_no'>Ward No</label>
                <input wire:model='benefitedMemberDetail.ward_no' name='ward_no' type='text' class='form-control' placeholder='Enter Ward No'>
                <div>
                    @error('benefitedMemberDetail.ward_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='village'>Village</label>
                <input wire:model='benefitedMemberDetail.village' name='village' type='text' class='form-control' placeholder='Enter Village'>
                <div>
                    @error('benefitedMemberDetail.village')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='dalit_backward_no'>Dalit Backward No</label>
                <input wire:model='benefitedMemberDetail.dalit_backward_no' name='dalit_backward_no' type='text' class='form-control' placeholder='Enter Dalit Backward No'>
                <div>
                    @error('benefitedMemberDetail.dalit_backward_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='other_households_no'>Other Households No</label>
                <input wire:model='benefitedMemberDetail.other_households_no' name='other_households_no' type='text' class='form-control' placeholder='Enter Other Households No'>
                <div>
                    @error('benefitedMemberDetail.other_households_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='no_of_male'>No Of Male</label>
                <input wire:model='benefitedMemberDetail.no_of_male' name='no_of_male' type='text' class='form-control' placeholder='Enter No Of Male'>
                <div>
                    @error('benefitedMemberDetail.no_of_male')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='no_of_female'>No Of Female</label>
                <input wire:model='benefitedMemberDetail.no_of_female' name='no_of_female' type='text' class='form-control' placeholder='Enter No Of Female'>
                <div>
                    @error('benefitedMemberDetail.no_of_female')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='no_of_others'>No Of Others</label>
                <input wire:model='benefitedMemberDetail.no_of_others' name='no_of_others' type='text' class='form-control' placeholder='Enter No Of Others'>
                <div>
                    @error('benefitedMemberDetail.no_of_others')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.benefited_member_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
