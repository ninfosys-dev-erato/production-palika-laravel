<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name_eng'>{{ __('beruju::beruju.name_eng') }}</label>
                    <input wire:model='subCategory.name_eng' name='name_eng' type='text' class='form-control'
                        placeholder="{{ __('beruju::beruju.enter_sub_category_name_eng') }}">
                    <div>
                        @error('subCategory.name_eng')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='name_nep'>{{ __('beruju::beruju.name_nep') }}</label>
                    <input wire:model='subCategory.name_nep' name='name_nep' type='text' class='form-control'
                        placeholder="{{ __('beruju::beruju.enter_sub_category_name_nep') }}">
                    <div>
                        @error('subCategory.name_nep')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='slug'>{{ __('beruju::beruju.slug') }}</label>
                    <input wire:model='subCategory.slug' name='slug' type='text' class='form-control'
                        placeholder="{{ __('beruju::beruju.enter_slug') }}">
                    <div>
                        @error('subCategory.slug')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='parent_id'>{{ __('beruju::beruju.parent_category') }}</label>
                    <select wire:model='subCategory.parent_id' name='parent_id' class="form-control">
                        <option value=""hidden>{{ __('beruju::beruju.select_parent_category') }}</option>
                        @foreach ($parentCategories as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('subCategory.parent_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='remarks'>{{ __('beruju::beruju.remarks') }}</label>
                    <textarea wire:model='subCategory.remarks' name='remarks' class='form-control'
                        placeholder="{{ __('beruju::beruju.enter_remarks') }}"></textarea>
                    <div>
                        @error('subCategory.remarks')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('beruju::beruju.save') }}</button>
        <button class="btn btn-danger" wire:loading.attr="disabled" data-bs-dismiss="modal"
            onclick="resetForm()">{{ __('beruju::beruju.back') }}</button>
    </div>
</form>
