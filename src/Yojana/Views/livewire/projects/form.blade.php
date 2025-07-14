<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='registration_no'>Registration No</label>
                <input wire:model='project.registration_no' name='registration_no' type='text' class='form-control' placeholder='Enter Registration No'>
                <div>
                    @error('project.registration_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='fiscal_year_id'>Fiscal Year Id</label>
                <input wire:model='project.fiscal_year_id' name='fiscal_year_id' type='text' class='form-control' placeholder='Enter Fiscal Year Id'>
                <div>
                    @error('project.fiscal_year_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='project_name'>Project Name</label>
                <input wire:model='project.project_name' name='project_name' type='text' class='form-control' placeholder='Enter Project Name'>
                <div>
                    @error('project.project_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='plan_area_id'>Plan Area Id</label>
                <input wire:model='project.plan_area_id' name='plan_area_id' type='text' class='form-control' placeholder='Enter Plan Area Id'>
                <div>
                    @error('project.plan_area_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='project_status'>Project Status</label>
                <input wire:model='project.project_status' name='project_status' type='text' class='form-control' placeholder='Enter Project Status'>
                <div>
                    @error('project.project_status')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='project_start_date'>Project Start Date</label>
                <input wire:model='project.project_start_date' name='project_start_date' type='text' class='form-control' placeholder='Enter Project Start Date'>
                <div>
                    @error('project.project_start_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='project_completion_date'>Project Completion Date</label>
                <input wire:model='project.project_completion_date' name='project_completion_date' type='text' class='form-control' placeholder='Enter Project Completion Date'>
                <div>
                    @error('project.project_completion_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='plan_level_id'>Plan Level Id</label>
                <input wire:model='project.plan_level_id' name='plan_level_id' type='text' class='form-control' placeholder='Enter Plan Level Id'>
                <div>
                    @error('project.plan_level_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='ward_no'>Ward No</label>
                <input wire:model='project.ward_no' name='ward_no' type='text' class='form-control' placeholder='Enter Ward No'>
                <div>
                    @error('project.ward_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='allocated_amount'>Allocated Amount</label>
                <input wire:model='project.allocated_amount' name='allocated_amount' type='text' class='form-control' placeholder='Enter Allocated Amount'>
                <div>
                    @error('project.allocated_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='project_venue'>Project Venue</label>
                <input wire:model='project.project_venue' name='project_venue' type='text' class='form-control' placeholder='Enter Project Venue'>
                <div>
                    @error('project.project_venue')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='evaluation_amount'>Evaluation Amount</label>
                <input wire:model='project.evaluation_amount' name='evaluation_amount' type='text' class='form-control' placeholder='Enter Evaluation Amount'>
                <div>
                    @error('project.evaluation_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='purpose'>Purpose</label>
                <input wire:model='project.purpose' name='purpose' type='text' class='form-control' placeholder='Enter Purpose'>
                <div>
                    @error('project.purpose')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='operated_through'>Operated Through</label>
                <input wire:model='project.operated_through' name='operated_through' type='text' class='form-control' placeholder='Enter Operated Through'>
                <div>
                    @error('project.operated_through')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='progress_spent_amount'>Progress Spent Amount</label>
                <input wire:model='project.progress_spent_amount' name='progress_spent_amount' type='text' class='form-control' placeholder='Enter Progress Spent Amount'>
                <div>
                    @error('project.progress_spent_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='physical_progress_target'>Physical Progress Target</label>
                <input wire:model='project.physical_progress_target' name='physical_progress_target' type='text' class='form-control' placeholder='Enter Physical Progress Target'>
                <div>
                    @error('project.physical_progress_target')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='physical_progress_completed'>Physical Progress Completed</label>
                <input wire:model='project.physical_progress_completed' name='physical_progress_completed' type='text' class='form-control' placeholder='Enter Physical Progress Completed'>
                <div>
                    @error('project.physical_progress_completed')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='physical_progress_unit'>Physical Progress Unit</label>
                <input wire:model='project.physical_progress_unit' name='physical_progress_unit' type='text' class='form-control' placeholder='Enter Physical Progress Unit'>
                <div>
                    @error('project.physical_progress_unit')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='first_quarterly_amount'>First Quarterly Amount</label>
                <input wire:model='project.first_quarterly_amount' name='first_quarterly_amount' type='text' class='form-control' placeholder='Enter First Quarterly Amount'>
                <div>
                    @error('project.first_quarterly_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='first_quarterly_goal'>First Quarterly Goal</label>
                <input wire:model='project.first_quarterly_goal' name='first_quarterly_goal' type='text' class='form-control' placeholder='Enter First Quarterly Goal'>
                <div>
                    @error('project.first_quarterly_goal')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='second_quarterly_amount'>Second Quarterly Amount</label>
                <input wire:model='project.second_quarterly_amount' name='second_quarterly_amount' type='text' class='form-control' placeholder='Enter Second Quarterly Amount'>
                <div>
                    @error('project.second_quarterly_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='second_quarterly_goal'>Second Quarterly Goal</label>
                <input wire:model='project.second_quarterly_goal' name='second_quarterly_goal' type='text' class='form-control' placeholder='Enter Second Quarterly Goal'>
                <div>
                    @error('project.second_quarterly_goal')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='third_quarterly_amount'>Third Quarterly Amount</label>
                <input wire:model='project.third_quarterly_amount' name='third_quarterly_amount' type='text' class='form-control' placeholder='Enter Third Quarterly Amount'>
                <div>
                    @error('project.third_quarterly_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='third_quarterly_goal'>Third Quarterly Goal</label>
                <input wire:model='project.third_quarterly_goal' name='third_quarterly_goal' type='text' class='form-control' placeholder='Enter Third Quarterly Goal'>
                <div>
                    @error('project.third_quarterly_goal')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='agencies_grants'>Agencies Grants</label>
                <input wire:model='project.agencies_grants' name='agencies_grants' type='text' class='form-control' placeholder='Enter Agencies Grants'>
                <div>
                    @error('project.agencies_grants')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='share_amount'>Share Amount</label>
                <input wire:model='project.share_amount' name='share_amount' type='text' class='form-control' placeholder='Enter Share Amount'>
                <div>
                    @error('project.share_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='committee_share_amount'>Committee Share Amount</label>
                <input wire:model='project.committee_share_amount' name='committee_share_amount' type='text' class='form-control' placeholder='Enter Committee Share Amount'>
                <div>
                    @error('project.committee_share_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='labor_amount'>Labor Amount</label>
                <input wire:model='project.labor_amount' name='labor_amount' type='text' class='form-control' placeholder='Enter Labor Amount'>
                <div>
                    @error('project.labor_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='benefited_organization'>Benefited Organization</label>
                <input wire:model='project.benefited_organization' name='benefited_organization' type='text' class='form-control' placeholder='Enter Benefited Organization'>
                <div>
                    @error('project.benefited_organization')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='others_benefited'>Others Benefited</label>
                <input wire:model='project.others_benefited' name='others_benefited' type='text' class='form-control' placeholder='Enter Others Benefited'>
                <div>
                    @error('project.others_benefited')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='expense_head_id'>Expense Head Id</label>
                <input wire:model='project.expense_head_id' name='expense_head_id' type='text' class='form-control' placeholder='Enter Expense Head Id'>
                <div>
                    @error('project.expense_head_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contingency_amount'>Contingency Amount</label>
                <input wire:model='project.contingency_amount' name='contingency_amount' type='text' class='form-control' placeholder='Enter Contingency Amount'>
                <div>
                    @error('project.contingency_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='other_taxes'>Other Taxes</label>
                <input wire:model='project.other_taxes' name='other_taxes' type='text' class='form-control' placeholder='Enter Other Taxes'>
                <div>
                    @error('project.other_taxes')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='is_contracted'>Is Contracted</label>
                <input wire:model='project.is_contracted' name='is_contracted' type='text' class='form-control' placeholder='Enter Is Contracted'>
                <div>
                    @error('project.is_contracted')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_date'>Contract Date</label>
                <input wire:model='project.contract_date' name='contract_date' type='text' class='form-control' placeholder='Enter Contract Date'>
                <div>
                    @error('project.contract_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.projects.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
