<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='district_id'>District Id</label>
                    <input wire:model='localBody.district_id' name='district_id' type='text' class='form-control'
                        placeholder='Enter District Id'>
                    <div>
                        @error('localBody.district_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title'>Title</label>
                    <input wire:model='localBody.title' name='title' type='text' class='form-control'
                        placeholder='Enter Title'>
                    <div>
                        @error('localBody.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title_en'>Title En</label>
                    <input wire:model='localBody.title_en' name='title_en' type='text' class='form-control'
                        placeholder='Enter Title En'>
                    <div>
                        @error('localBody.title_en')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='wards'>Wards</label>
                    <input wire:model='localBody.wards' name='wards' type='text' class='form-control'
                        placeholder='Enter Wards'>
                    <div>
                        @error('localBody.wards')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{ route('admin.local-bodies.index') }}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
