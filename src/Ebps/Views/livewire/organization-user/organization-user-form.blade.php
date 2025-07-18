<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='name'>Name</label>
                <input wire:model='organizationUser.name' name='name' type='text' class='form-control' placeholder='Enter Name'>
                <div>
                    @error('organizationUser.name')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='email'>Email</label>
                <input wire:model='organizationUser.email' name='email' type='text' class='form-control' placeholder='Enter Email'>
                <div>
                    @error('organizationUser.email')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='photo'>Photo</label>
                <input wire:model='organizationUser.photo' name='photo' type='text' class='form-control' placeholder='Enter Photo'>
                <div>
                    @error('organizationUser.photo')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='phone'>Phone</label>
                <input wire:model='organizationUser.phone' name='phone' type='text' class='form-control' placeholder='Enter Phone'>
                <div>
                    @error('organizationUser.phone')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='password'>Password</label>
                <input wire:model='organizationUser.password' name='password' type='text' class='form-control' placeholder='Enter Password'>
                <div>
                    @error('organizationUser.password')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='is_active'>Is Active</label>
                <input wire:model='organizationUser.is_active' name='is_active' type='text' class='form-control' placeholder='Enter Is Active'>
                <div>
                    @error('organizationUser.is_active')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='is_organization'>Is Organization</label>
                <input wire:model='organizationUser.is_organization' name='is_organization' type='text' class='form-control' placeholder='Enter Is Organization'>
                <div>
                    @error('organizationUser.is_organization')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='organizations_id'>Organizations Id</label>
                <input wire:model='organizationUser.organizations_id' name='organizations_id' type='text' class='form-control' placeholder='Enter Organizations Id'>
                <div>
                    @error('organizationUser.organizations_id')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='can_work'>Can Work</label>
                <input wire:model='organizationUser.can_work' name='can_work' type='text' class='form-control' placeholder='Enter Can Work'>
                <div>
                    @error('organizationUser.can_work')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='status'>Status</label>
                <input wire:model='organizationUser.status' name='status' type='text' class='form-control' placeholder='Enter Status'>
                <div>
                    @error('organizationUser.status')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='comment'>Comment</label>
                <input wire:model='organizationUser.comment' name='comment' type='text' class='form-control' placeholder='Enter Comment'>
                <div>
                    @error('organizationUser.comment')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.organization_users.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
