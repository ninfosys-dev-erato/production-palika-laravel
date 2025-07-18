<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='log_name'>Log Name</label>
                <input wire:model='activityLog.log_name' name='log_name' type='text' class='form-control' placeholder='Enter Log Name'>
                <div>
                    @error('activityLog.log_name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='description'>Description</label>
                <input wire:model='activityLog.description' name='description' type='text' class='form-control' placeholder='Enter Description'>
                <div>
                    @error('activityLog.description')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='subject_type'>Subject Type</label>
                <input wire:model='activityLog.subject_type' name='subject_type' type='text' class='form-control' placeholder='Enter Subject Type'>
                <div>
                    @error('activityLog.subject_type')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='event'>Event</label>
                <input wire:model='activityLog.event' name='event' type='text' class='form-control' placeholder='Enter Event'>
                <div>
                    @error('activityLog.event')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='subject_id'>Subject Id</label>
                <input wire:model='activityLog.subject_id' name='subject_id' type='text' class='form-control' placeholder='Enter Subject Id'>
                <div>
                    @error('activityLog.subject_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='causer_type'>Causer Type</label>
                <input wire:model='activityLog.causer_type' name='causer_type' type='text' class='form-control' placeholder='Enter Causer Type'>
                <div>
                    @error('activityLog.causer_type')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='causer_id'>Causer Id</label>
                <input wire:model='activityLog.causer_id' name='causer_id' type='text' class='form-control' placeholder='Enter Causer Id'>
                <div>
                    @error('activityLog.causer_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='properties'>Properties</label>
                <input wire:model='activityLog.properties' name='properties' type='text' class='form-control' placeholder='Enter Properties'>
                <div>
                    @error('activityLog.properties')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='batch_uuid'>Batch Uuid</label>
                <input wire:model='activityLog.batch_uuid' name='batch_uuid' type='text' class='form-control' placeholder='Enter Batch Uuid'>
                <div>
                    @error('activityLog.batch_uuid')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.activity_logs.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
