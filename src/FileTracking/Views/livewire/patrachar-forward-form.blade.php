<form>
    <div class="mb-3">
        <label for="receiver" class="form-label fw-semibold">{{__('filetracking::filetracking.receiver')}}</label>
        <select id="receiver" class="form-select select2" wire:model="receipent" required>
            <option value="" selected>-- {{__('filetracking::filetracking.select_receiver')}} --</option>
            @foreach ($receipents as $receipent)
                <option value="{{ get_class($receipent) . '::find(' . $receipent->id . ')' }}">
                    {{ $receipent->display_name }}
                </option>
            @endforeach
        </select>
        @error('receipent')
            <div class="text-danger">{{ __($message) }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="remarks" class="form-label fw-semibold">{{__('filetracking::filetracking.write_a_response')}}</label>
        <textarea id="remarks" wire:model="fileRecordLog.notes" class="form-control" placeholder={{__('filetracking::filetracking.add_your_remarks')}} rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label fw-semibold">{{__('filetracking::filetracking.upload_file')}}</label>
        <input id="file" type="file" class="form-control" wire:model="fileRecordLog.file">
    </div>
</form>