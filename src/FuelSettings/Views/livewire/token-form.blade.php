<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='token_no'>Token No</label>
                    <input wire:model='token.token_no' name='token_no' type='text' class='form-control'
                        placeholder='Enter Token No'>
                    <div>
                        @error('token.token_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='fiscal_year_id'>Fiscal Year Id</label>
                    <input wire:model='token.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control'
                        placeholder='Enter Fiscal Year Id'>
                    <div>
                        @error('token.fiscal_year_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='tokenable_type'>Tokenable Type</label>
                    <input wire:model='token.tokenable_type' name='tokenable_type' type='text' class='form-control'
                        placeholder='Enter Tokenable Type'>
                    <div>
                        @error('token.tokenable_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='tokenable_id'>Tokenable Id</label>
                    <input wire:model='token.tokenable_id' name='tokenable_id' type='text' class='form-control'
                        placeholder='Enter Tokenable Id'>
                    <div>
                        @error('token.tokenable_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='organization_id'>Organization Id</label>
                    <input wire:model='token.organization_id' name='organization_id' type='text' class='form-control'
                        placeholder='Enter Organization Id'>
                    <div>
                        @error('token.organization_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='fuel_quantity'>Fuel Quantity</label>
                    <input wire:model='token.fuel_quantity' name='fuel_quantity' type='text' class='form-control'
                        placeholder='Enter Fuel Quantity'>
                    <div>
                        @error('token.fuel_quantity')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='fuel_type'>Fuel Type</label>
                    <input wire:model='token.fuel_type' name='fuel_type' type='text' class='form-control'
                        placeholder='Enter Fuel Type'>
                    <div>
                        @error('token.fuel_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='status'>Status</label>
                    <input wire:model='token.status' name='status' type='text' class='form-control'
                        placeholder='Enter Status'>
                    <div>
                        @error('token.status')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- <div class='col-md-6'>
                <div class='form-group'>
                    <label for='accepted_at'>Accepted At</label>
                    <input wire:model='token.accepted_at' name='accepted_at' type='text' class='form-control'
                        placeholder='Enter Accepted At'>
                    <div>
                        @error('token.accepted_at')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='accepted_by'>Accepted By</label>
                    <input wire:model='token.accepted_by' name='accepted_by' type='text' class='form-control'
                        placeholder='Enter Accepted By'>
                    <div>
                        @error('token.accepted_by')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='reviewed_at'>Reviewed At</label>
                    <input wire:model='token.reviewed_at' name='reviewed_at' type='text' class='form-control'
                        placeholder='Enter Reviewed At'>
                    <div>
                        @error('token.reviewed_at')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='reviewed_by'>Reviewed By</label>
                    <input wire:model='token.reviewed_by' name='reviewed_by' type='text' class='form-control'
                        placeholder='Enter Reviewed By'>
                    <div>
                        @error('token.reviewed_by')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='expires_at'>Expires At</label>
                    <input wire:model='token.expires_at' name='expires_at' type='text' class='form-control'
                        placeholder='Enter Expires At'>
                    <div>
                        @error('token.expires_at')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='redeemed_at'>Redeemed At</label>
                    <input wire:model='token.redeemed_at' name='redeemed_at' type='text' class='form-control'
                        placeholder='Enter Redeemed At'>
                    <div>
                        @error('token.redeemed_at')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='redeemed_by'>Redeemed By</label>
                    <input wire:model='token.redeemed_by' name='redeemed_by' type='text' class='form-control'
                        placeholder='Enter Redeemed By'>
                    <div>
                        @error('token.redeemed_by')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='ward_no'>Ward No</label>
                    <input wire:model='token.ward_no' name='ward_no' type='text' class='form-control'
                        placeholder='Enter Ward No'>
                    <div>
                        @error('token.ward_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{ route('admin.tokens.index') }}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
