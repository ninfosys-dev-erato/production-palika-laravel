<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='reg_no'>{{__('filetracking::filetracking.reg_no')}}</label>
                    <input wire:model='fileRecordLog.reg_no' name='reg_no' type='text' class='form-control'
                        placeholder={{__('filetracking::filetracking.enter_reg_no')}}>
                    <div>
                        @error('fileRecordLog.reg_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='status'>{{__('filetracking::filetracking.status')}}</label>
                    <input wire:model='fileRecordLog.status' name='status' type='text' class='form-control'
                        placeholder='Enter Status'>
                    <div>
                        @error('fileRecordLog.status')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='notes'>{{__('filetracking::filetracking.notes')}}</label>
                    <input wire:model='fileRecordLog.notes' name='notes' type='text' class='form-control'
                        placeholder='Enter Notes'>
                    <div>
                        @error('fileRecordLog.notes')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='handler_type'>{{__('filetracking::filetracking.handler_type')}}</label>
                    <input wire:model='fileRecordLog.handler_type' name='handler_type' type='text' class='form-control'
                        placeholder='Enter Handler Type'>
                    <div>
                        @error('fileRecordLog.handler_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='handler_id'>{{__('filetracking::filetracking.handler_id')}}</label>
                    <input wire:model='fileRecordLog.handler_id' name='handler_id' type='text' class='form-control'
                        placeholder='Enter Handler Id'>
                    <div>
                        @error('fileRecordLog.handler_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('filetracking::filetracking.save')}}</button>
        <a href="{{route('admin.file_record_logs.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('filetracking::filetracking.back')}}</a>
    </div>
</form>