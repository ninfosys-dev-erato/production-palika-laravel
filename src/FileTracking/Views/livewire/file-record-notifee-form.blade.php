<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='file_record_log_id'>{{ __('filetracking::filetracking.file_record_log_id') }}</label>
                    <input wire:model='fileRecordNotifiee.file_record_log_id' name='file_record_log_id' type='text'
                        class='form-control' placeholder='Enter File Record Log Id'>
                    <div>
                        @error('fileRecordNotifiee.file_record_log_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='notifiable_type'>{{ __('filetracking::filetracking.notifiable_type') }}</label>
                    <input wire:model='fileRecordNotifiee.notifiable_type' name='notifiable_type' type='text'
                        class='form-control' placeholder='Enter Notifiable Type'>
                    <div>
                        @error('fileRecordNotifiee.notifiable_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='notifiable_id'>{{ __('filetracking::filetracking.notifiable_id') }}</label>
                    <input wire:model='fileRecordNotifiee.notifiable_id' name='notifiable_id' type='text'
                        class='form-control' placeholder='Enter Notifiable Id'>
                    <div>
                        @error('fileRecordNotifiee.notifiable_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('filetracking::filetracking.save') }}</button>
        <a href="{{ route('admin.file_record_notifiees.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('filetracking::filetracking.back') }}</a>
    </div>
</form>