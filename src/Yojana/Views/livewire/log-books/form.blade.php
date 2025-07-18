<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='employee_id' class='form-label'>{{__('yojana::yojana.employee')}}</label>
                    <select wire:model='logBook.employee_id' name='employee_id' type='text' class='form-control'>

                        <option value="" hidden>{{ __('yojana::yojana.select_an_employee') }}</option>
                        @foreach ($employees as $employeeId => $employeeName)
                            <option value="{{ $employeeId }}">{{ $employeeName }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('logBook.employee_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='date' class='form-label'>{{__('yojana::yojana.date')}}</label>
                    <input wire:model='logBook.date' name='date' type='date' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_date')}}">
                    <div>
                        @error('logBook.date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='visit_time' class='form-label'>{{__('yojana::yojana.visit_time')}}</label>
                    <input wire:model='logBook.visit_time' name='visit_time' type='time' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_visit_time')}}">
                    <div>
                        @error('logBook.visit_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='return_time' class='form-label'>{{__('yojana::yojana.return_time')}}</label>
                    <input wire:model='logBook.return_time' name='return_time' type='time' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_return_time')}}">
                    <div>
                        @error('logBook.return_time')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='visit_type' class='form-label'>{{__('yojana::yojana.visit_type')}}</label>
                    <input wire:model='logBook.visit_type' name='visit_type' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_visit_type')}}">
                    <div>
                        @error('logBook.visit_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='visit_purpose' class='form-label'>{{__('yojana::yojana.visit_purpose')}}</label>
                    <input wire:model='logBook.visit_purpose' name='visit_purpose' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_visit_purpose')}}">
                    <div>
                        @error('logBook.visit_purpose')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='description' class='form-label'>{{__('yojana::yojana.description')}}</label>
                    <input wire:model='logBook.description' name='description' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_description')}}">
                    <div>
                        @error('logBook.description')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.log_books.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
