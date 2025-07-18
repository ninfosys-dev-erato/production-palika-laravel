<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                @php
                    $status = $this->costEstimation?->status ?? null;
                @endphp
                <div class='form-group'>
                    <label class="form-label" for='forwarded_to'>{{__('yojana::yojana.status')}}</label>
                @if ($status == null || $status == 'Returned To Creator')
                        <input type='text' value="{{__('Forward To Review')}}" class='form-control' readonly wire:init="setStatus('Sent For Review')">
                    @elseif ($status === 'Sent For Review' || $status === 'Return To Review' )
                        <div>
                            <div class="form-check">
                                <input wire:click="setStatus('Returned To Creator')" type="radio" name="statusOptions" class="form-check-input" id="returnToCreator">
                                <label for="returnToCreator" class="form-check-label">{{__('yojana::yojana.return_to_creator')}}</label>
                            </div>
                            <div class="form-check">
                                <input wire:click="setStatus('Forwarded To Approval')" type="radio" name="statusOptions" class="form-check-input" id="forwardToApprover">
                                <label for="forwardToApproval" class="form-check-label">{{__('yojana::yojana.forward_to_approval')}}</label>
                            </div>
                        </div>
                    @elseif ($status === 'Forwarded To Approval')
                        <div>
                            <div class="form-check">
                                <input wire:click="setStatus('Return To Review')" type="radio" name="statusOptions" class="form-check-input" id="returnToCheck">
                                <label for="returnToCheck" class="form-check-label">{{__('yojana::yojana.return_to_check')}}</label>
                            </div>
                            <div class="form-check">
                                <input wire:click="setStatus('Approved')" type="radio" name="statusOptions" class="form-check-input" id="approve">
                                <label for="approve" class="form-check-label">{{__('yojana::yojana.approve')}}</label>
                            </div>
                        </div>
                    @else
                        <input wire:model.defer='costEstimationLog.status' type='text' class='form-control' readonly>
                    @endif
                </div>

            </div><div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='forwarded_to'>{{__('yojana::yojana.forward_to')}}</label>
                    <select wire:model='costEstimationLog.forwarded_to' name='forwarded_to' type='text' class='form-control'>
                        <option hidden=""> --- {{__('yojana::yojana.select')}} --- </option>
                        @foreach($employees as $employee)
                            <option value="{{$employee->id}}"> {{$employee->name . " | ". $employee->phone}} </option>
                        @endforeach
                    </select>
                    <div>
                        @error('costEstimationLog.forwarded_to')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='remarks'>{{__('yojana::yojana.remarks')}}</label>
                    <input wire:model='costEstimationLog.remarks' name='remarks' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_remarks')}}">
                    <div>
                        @error('costEstimationLog.remarks')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='date'>{{__('yojana::yojana.date')}}</label>
                    <input wire:model='costEstimationLog.date' name='date' type='text' class='form-control' readonly>
                    <div>
                        @error('costEstimationLog.date')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="" wire:loading.attr="disabled" class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
