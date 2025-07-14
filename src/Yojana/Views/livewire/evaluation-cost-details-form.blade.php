<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='evaluation_id' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailevaluation_id') }}</label>
                    <input wire:model='evaluationCostDetail.evaluation_id' name='evaluation_id' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailevaluation_identer') }}">
                    <div>
                        @error('evaluationCostDetail.evaluation_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='activity_id' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailactivity_id') }}</label>
                    <input wire:model='evaluationCostDetail.activity_id' name='activity_id' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailactivity_identer') }}">
                    <div>
                        @error('evaluationCostDetail.activity_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='unit' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailunit') }}</label>
                    <input wire:model='evaluationCostDetail.unit' name='unit' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailunitenter') }}">
                    <div>
                        @error('evaluationCostDetail.unit')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='agreement' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailagreement') }}</label>
                    <input wire:model='evaluationCostDetail.agreement' name='agreement' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailagreemententer') }}">
                    <div>
                        @error('evaluationCostDetail.agreement')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='before_this' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailbefore_this') }}</label>
                    <input wire:model='evaluationCostDetail.before_this' name='before_this' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailbefore_thisenter') }}">
                    <div>
                        @error('evaluationCostDetail.before_this')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='up_to_date_amount' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailup_to_date_amount') }}</label>
                    <input wire:model='evaluationCostDetail.up_to_date_amount' name='up_to_date_amount' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailup_to_date_amountenter') }}">
                    <div>
                        @error('evaluationCostDetail.up_to_date_amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='current' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailcurrent') }}</label>
                    <input wire:model='evaluationCostDetail.current' name='current' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailcurrententer') }}">
                    <div>
                        @error('evaluationCostDetail.current')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='rate' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailrate') }}</label>
                    <input wire:model='evaluationCostDetail.rate' name='rate' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailrateenter') }}">
                    <div>
                        @error('evaluationCostDetail.rate')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='assessment_amount' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailassessment_amount') }}</label>
                    <input wire:model='evaluationCostDetail.assessment_amount' name='assessment_amount' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailassessment_amountenter') }}">
                    <div>
                        @error('evaluationCostDetail.assessment_amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div><div class='col-md-6'>
                <div class='form-group'>
                    <label for='vat_amount' class='form-label'>{{ __('yojana::yojana.evaluationcostdetailvat_amount') }}</label>
                    <input wire:model='evaluationCostDetail.vat_amount' name='vat_amount' type='text' class='form-control' placeholder="{{ __('yojana::yojana.evaluationcostdetailvat_amountenter') }}">
                    <div>
                        @error('evaluationCostDetail.vat_amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.evaluation_cost_details.index')}}" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
