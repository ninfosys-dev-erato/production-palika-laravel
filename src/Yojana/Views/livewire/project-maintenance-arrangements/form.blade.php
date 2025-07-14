<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectMaintenanceArrangement.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectMaintenanceArrangement.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='office_name'>Office Name</label>
                <input wire:model='projectMaintenanceArrangement.office_name' name='office_name' type='text' class='form-control' placeholder='Enter Office Name'>
                <div>
                    @error('projectMaintenanceArrangement.office_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='public_service'>Public Service</label>
                <input wire:model='projectMaintenanceArrangement.public_service' name='public_service' type='text' class='form-control' placeholder='Enter Public Service'>
                <div>
                    @error('projectMaintenanceArrangement.public_service')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='service_fee'>Service Fee</label>
                <input wire:model='projectMaintenanceArrangement.service_fee' name='service_fee' type='text' class='form-control' placeholder='Enter Service Fee'>
                <div>
                    @error('projectMaintenanceArrangement.service_fee')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='from_fee_donation'>From Fee Donation</label>
                <input wire:model='projectMaintenanceArrangement.from_fee_donation' name='from_fee_donation' type='text' class='form-control' placeholder='Enter From Fee Donation'>
                <div>
                    @error('projectMaintenanceArrangement.from_fee_donation')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='others'>Others</label>
                <input wire:model='projectMaintenanceArrangement.others' name='others' type='text' class='form-control' placeholder='Enter Others'>
                <div>
                    @error('projectMaintenanceArrangement.others')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_maintenance_arrangements.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
