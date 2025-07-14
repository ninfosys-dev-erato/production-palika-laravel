<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectDeadlineExtension.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectDeadlineExtension.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='extended_date'>Extended Date</label>
                <input wire:model='projectDeadlineExtension.extended_date' name='extended_date' type='text' class='form-control' placeholder='Enter Extended Date'>
                <div>
                    @error('projectDeadlineExtension.extended_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='en_extended_date'>En Extended Date</label>
                <input wire:model='projectDeadlineExtension.en_extended_date' name='en_extended_date' type='text' class='form-control' placeholder='Enter En Extended Date'>
                <div>
                    @error('projectDeadlineExtension.en_extended_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='submitted_date'>Submitted Date</label>
                <input wire:model='projectDeadlineExtension.submitted_date' name='submitted_date' type='text' class='form-control' placeholder='Enter Submitted Date'>
                <div>
                    @error('projectDeadlineExtension.submitted_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='en_submitted_date'>En Submitted Date</label>
                <input wire:model='projectDeadlineExtension.en_submitted_date' name='en_submitted_date' type='text' class='form-control' placeholder='Enter En Submitted Date'>
                <div>
                    @error('projectDeadlineExtension.en_submitted_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='remarks'>Remarks</label>
                <input wire:model='projectDeadlineExtension.remarks' name='remarks' type='text' class='form-control' placeholder='Enter Remarks'>
                <div>
                    @error('projectDeadlineExtension.remarks')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_deadline_extensions.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
