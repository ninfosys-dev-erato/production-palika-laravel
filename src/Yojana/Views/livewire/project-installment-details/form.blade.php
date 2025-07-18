<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectInstallmentDetail.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectInstallmentDetail.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='installment_type'>Installment Type</label>
                <input wire:model='projectInstallmentDetail.installment_type' name='installment_type' type='text' class='form-control' placeholder='Enter Installment Type'>
                <div>
                    @error('projectInstallmentDetail.installment_type')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='date'>Date</label>
                <input wire:model='projectInstallmentDetail.date' name='date' type='text' class='form-control' placeholder='Enter Date'>
                <div>
                    @error('projectInstallmentDetail.date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='amount'>Amount</label>
                <input wire:model='projectInstallmentDetail.amount' name='amount' type='text' class='form-control' placeholder='Enter Amount'>
                <div>
                    @error('projectInstallmentDetail.amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='construction_material_quantity'>Construction Material Quantity</label>
                <input wire:model='projectInstallmentDetail.construction_material_quantity' name='construction_material_quantity' type='text' class='form-control' placeholder='Enter Construction Material Quantity'>
                <div>
                    @error('projectInstallmentDetail.construction_material_quantity')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='remarks'>Remarks</label>
                <input wire:model='projectInstallmentDetail.remarks' name='remarks' type='text' class='form-control' placeholder='Enter Remarks'>
                <div>
                    @error('projectInstallmentDetail.remarks')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_installment_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
