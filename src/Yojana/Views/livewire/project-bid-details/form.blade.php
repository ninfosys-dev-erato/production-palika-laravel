<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
            <div class='form-group'>
                <label for='project_id'>Project Id</label>
                <input wire:model='projectBidDetail.project_id' name='project_id' type='text' class='form-control' placeholder='Enter Project Id'>
                <div>
                    @error('projectBidDetail.project_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='cost_estimation'>Cost Estimation</label>
                <input wire:model='projectBidDetail.cost_estimation' name='cost_estimation' type='text' class='form-control' placeholder='Enter Cost Estimation'>
                <div>
                    @error('projectBidDetail.cost_estimation')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='notice_published_date'>Notice Published Date</label>
                <input wire:model='projectBidDetail.notice_published_date' name='notice_published_date' type='text' class='form-control' placeholder='Enter Notice Published Date'>
                <div>
                    @error('projectBidDetail.notice_published_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='newspaper_name'>Newspaper Name</label>
                <input wire:model='projectBidDetail.newspaper_name' name='newspaper_name' type='text' class='form-control' placeholder='Enter Newspaper Name'>
                <div>
                    @error('projectBidDetail.newspaper_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_evaluation_decision_date'>Contract Evaluation Decision Date</label>
                <input wire:model='projectBidDetail.contract_evaluation_decision_date' name='contract_evaluation_decision_date' type='text' class='form-control' placeholder='Enter Contract Evaluation Decision Date'>
                <div>
                    @error('projectBidDetail.contract_evaluation_decision_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='intent_notice_publish_date'>Intent Notice Publish Date</label>
                <input wire:model='projectBidDetail.intent_notice_publish_date' name='intent_notice_publish_date' type='text' class='form-control' placeholder='Enter Intent Notice Publish Date'>
                <div>
                    @error('projectBidDetail.intent_notice_publish_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_newspaper_name'>Contract Newspaper Name</label>
                <input wire:model='projectBidDetail.contract_newspaper_name' name='contract_newspaper_name' type='text' class='form-control' placeholder='Enter Contract Newspaper Name'>
                <div>
                    @error('projectBidDetail.contract_newspaper_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_acceptance_decision_date'>Contract Acceptance Decision Date</label>
                <input wire:model='projectBidDetail.contract_acceptance_decision_date' name='contract_acceptance_decision_date' type='text' class='form-control' placeholder='Enter Contract Acceptance Decision Date'>
                <div>
                    @error('projectBidDetail.contract_acceptance_decision_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_percentage'>Contract Percentage</label>
                <input wire:model='projectBidDetail.contract_percentage' name='contract_percentage' type='text' class='form-control' placeholder='Enter Contract Percentage'>
                <div>
                    @error('projectBidDetail.contract_percentage')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contractor_name'>Contractor Name</label>
                <input wire:model='projectBidDetail.contractor_name' name='contractor_name' type='text' class='form-control' placeholder='Enter Contractor Name'>
                <div>
                    @error('projectBidDetail.contractor_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contractor_address'>Contractor Address</label>
                <input wire:model='projectBidDetail.contractor_address' name='contractor_address' type='text' class='form-control' placeholder='Enter Contractor Address'>
                <div>
                    @error('projectBidDetail.contractor_address')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contractor_phone'>Contractor Phone</label>
                <input wire:model='projectBidDetail.contractor_phone' name='contractor_phone' type='text' class='form-control' placeholder='Enter Contractor Phone'>
                <div>
                    @error('projectBidDetail.contractor_phone')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='confession_number'>Confession Number</label>
                <input wire:model='projectBidDetail.confession_number' name='confession_number' type='text' class='form-control' placeholder='Enter Confession Number'>
                <div>
                    @error('projectBidDetail.confession_number')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_agreement_date'>Contract Agreement Date</label>
                <input wire:model='projectBidDetail.contract_agreement_date' name='contract_agreement_date' type='text' class='form-control' placeholder='Enter Contract Agreement Date'>
                <div>
                    @error('projectBidDetail.contract_agreement_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='contract_assigned_date'>Contract Assigned Date</label>
                <input wire:model='projectBidDetail.contract_assigned_date' name='contract_assigned_date' type='text' class='form-control' placeholder='Enter Contract Assigned Date'>
                <div>
                    @error('projectBidDetail.contract_assigned_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='bid_bond_amount'>Bid Bond Amount</label>
                <input wire:model='projectBidDetail.bid_bond_amount' name='bid_bond_amount' type='text' class='form-control' placeholder='Enter Bid Bond Amount'>
                <div>
                    @error('projectBidDetail.bid_bond_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='bid_bond_no'>Bid Bond No</label>
                <input wire:model='projectBidDetail.bid_bond_no' name='bid_bond_no' type='text' class='form-control' placeholder='Enter Bid Bond No'>
                <div>
                    @error('projectBidDetail.bid_bond_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='bid_bond_bank_name'>Bid Bond Bank Name</label>
                <input wire:model='projectBidDetail.bid_bond_bank_name' name='bid_bond_bank_name' type='text' class='form-control' placeholder='Enter Bid Bond Bank Name'>
                <div>
                    @error('projectBidDetail.bid_bond_bank_name')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='bid_bond_issue_date'>Bid Bond Issue Date</label>
                <input wire:model='projectBidDetail.bid_bond_issue_date' name='bid_bond_issue_date' type='text' class='form-control' placeholder='Enter Bid Bond Issue Date'>
                <div>
                    @error('projectBidDetail.bid_bond_issue_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='bid_bond_expiry_date'>Bid Bond Expiry Date</label>
                <input wire:model='projectBidDetail.bid_bond_expiry_date' name='bid_bond_expiry_date' type='text' class='form-control' placeholder='Enter Bid Bond Expiry Date'>
                <div>
                    @error('projectBidDetail.bid_bond_expiry_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='performance_bond_no'>Performance Bond No</label>
                <input wire:model='projectBidDetail.performance_bond_no' name='performance_bond_no' type='text' class='form-control' placeholder='Enter Performance Bond No'>
                <div>
                    @error('projectBidDetail.performance_bond_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='performance_bond_amount'>Performance Bond Amount</label>
                <input wire:model='projectBidDetail.performance_bond_amount' name='performance_bond_amount' type='text' class='form-control' placeholder='Enter Performance Bond Amount'>
                <div>
                    @error('projectBidDetail.performance_bond_amount')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='performance_bond_bank'>Performance Bond Bank</label>
                <input wire:model='projectBidDetail.performance_bond_bank' name='performance_bond_bank' type='text' class='form-control' placeholder='Enter Performance Bond Bank'>
                <div>
                    @error('projectBidDetail.performance_bond_bank')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='performance_bond_issue_date'>Performance Bond Issue Date</label>
                <input wire:model='projectBidDetail.performance_bond_issue_date' name='performance_bond_issue_date' type='text' class='form-control' placeholder='Enter Performance Bond Issue Date'>
                <div>
                    @error('projectBidDetail.performance_bond_issue_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='performance_bond_expiry_date'>Performance Bond Expiry Date</label>
                <input wire:model='projectBidDetail.performance_bond_expiry_date' name='performance_bond_expiry_date' type='text' class='form-control' placeholder='Enter Performance Bond Expiry Date'>
                <div>
                    @error('projectBidDetail.performance_bond_expiry_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='performance_bond_extended_date'>Performance Bond Extended Date</label>
                <input wire:model='projectBidDetail.performance_bond_extended_date' name='performance_bond_extended_date' type='text' class='form-control' placeholder='Enter Performance Bond Extended Date'>
                <div>
                    @error('projectBidDetail.performance_bond_extended_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='insurance_issue_date'>Insurance Issue Date</label>
                <input wire:model='projectBidDetail.insurance_issue_date' name='insurance_issue_date' type='text' class='form-control' placeholder='Enter Insurance Issue Date'>
                <div>
                    @error('projectBidDetail.insurance_issue_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='insurance_expiry_date'>Insurance Expiry Date</label>
                <input wire:model='projectBidDetail.insurance_expiry_date' name='insurance_expiry_date' type='text' class='form-control' placeholder='Enter Insurance Expiry Date'>
                <div>
                    @error('projectBidDetail.insurance_expiry_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='insurance_extended_date'>Insurance Extended Date</label>
                <input wire:model='projectBidDetail.insurance_extended_date' name='insurance_extended_date' type='text' class='form-control' placeholder='Enter Insurance Extended Date'>
                <div>
                    @error('projectBidDetail.insurance_extended_date')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div><div class='col-md-6'>
            <div class='form-group'>
                <label for='bid_no'>Bid No</label>
                <input wire:model='projectBidDetail.bid_no' name='bid_no' type='text' class='form-control' placeholder='Enter Bid No'>
                <div>
                    @error('projectBidDetail.bid_no')
                        <small class='text-danger'>{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Save</button>
        <a href="{{route('admin.project_bid_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">Back</a>
    </div>
</form>
