<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name_eng'>{{ __('beruju::beruju.name_eng') }}</label>
                    <input wire:model='actionType.name_eng' name='name_eng' type='text' class='form-control rounded-0'
                        placeholder="{{ __('beruju::beruju.enter_action_type_name_eng') }}">
                    <div>
                        @error('actionType.name_eng')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name_nep'>{{ __('beruju::beruju.name_nep') }}</label>
                    <input wire:model='actionType.name_nep' name='name_nep' type='text' class='form-control rounded-0'
                        placeholder="{{ __('beruju::beruju.enter_action_type_name_nep') }}">
                    <div>
                        @error('actionType.name_nep')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='sub_category_id'>{{ __('beruju::beruju.sub_category') }}</label>
                    <select wire:model='actionType.sub_category_id' name='sub_category_id' class='form-control rounded-0'>
                        <option value=''>{{ __('beruju::beruju.select_sub_category') }}</option>
                        @foreach($subCategories as $id => $name)
                            <option value='{{ $id }}'>{{ $name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('actionType.sub_category_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='form_id'>{{ __('beruju::beruju.form') }}</label>
                    <input wire:model='actionType.form_id' name='form_id' type='number' class='form-control rounded-0'
                        placeholder="{{ __('beruju::beruju.form') }}">
                    <div>
                        @error('actionType.form_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='remarks'>{{ __('beruju::beruju.remarks') }}</label>
                    <textarea wire:model='actionType.remarks' name='remarks' class='form-control rounded-0' rows='3'
                        placeholder="{{ __('beruju::beruju.enter_remarks') }}"></textarea>
                    <div>
                        @error('actionType.remarks')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">
                {{ __('beruju::beruju.cancel') }}
            </button>
            <button type="submit" class="btn btn-primary rounded-0">
                @if($action === App\Enums\Action::CREATE)
                    {{ __('beruju::beruju.create') }}
                @else
                    {{ __('beruju::beruju.update') }}
                @endif
            </button>
        </div>
    </div>
</form>
