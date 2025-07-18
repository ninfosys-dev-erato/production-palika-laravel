<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='process_indicator' class='form-label'>{{__('yojana::yojana.progress_indicator')}}</label>
                    <select wire:model='process_indicator' name='process_indicator' type='text' wire:change="loadTargetEntry($event.target.value)"
                            class='form-control {{ $errors->has('process_indicator') ? 'is-invalid' : '' }}'>
                        @foreach($targetEntries as $targetEntry)
                            <option value="{{$targetEntry->id}}">{{$targetEntry->processIndicator->title}}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('process_indicator')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('yojana::yojana.target_type') }}</th>
                <th>{{ __('yojana::yojana.remaining_goals') }}</th>
                <th>{{ __('yojana::yojana.completed_goals') }}</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{__('yojana::yojana.physical_progress')}}</td>
                    <td>
                        {{ $targetCompletion->physical_goals  }}
                    </td>
                    <td>
                        <input wire:model='targetCompletion.completed_physical_goal' name='completed_physical_goal' type='number' class='form-control' placeholder="{{ __('yojana::yojana.enter_completed_physical_goal') }}">

                    </td>
                </tr>
                <tr>
                    <td>{{__('yojana::yojana.financial_progress')}}</td>

                    <td>
                        {{ $targetCompletion->financial_goals }}
                    </td>
                    <td>
                        <input wire:model='targetCompletion.completed_financial_goal' name='completed_financial_goal' type='number' class='form-control' placeholder="{{ __('yojana::yojana.enter_completed_financial_goal') }}">

                    </td>
                </tr>
            </tbody>

        </table>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <button class="btn btn-danger" wire:loading.attr="disabled" data-bs-dismiss="modal"
                onclick="resetForm()">{{ __('yojana::yojana.back') }}</button>
    </div>
</form>
