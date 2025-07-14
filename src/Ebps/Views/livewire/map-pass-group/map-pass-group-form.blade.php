<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('ebps::ebps.title') }}</label>
                    <input wire:model='mapPassGroup.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_title') }}">
                    <div>
                        @error('mapPassGroup.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class=" d-flex justify-content-between">
                <label class="form-label" for="form-label">{{ __('ebps::ebps.users') }}</label>
                <button type="button" class="btn btn-info" wire:click='addUser'>
                    + {{ __('ebps::ebps.add_users') }}
                </button>
            </div>

            @foreach ($userSelects as $index => $selected)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="user-{{ $index }}">{{ __('ebps::ebps.user') }}</label>
                                            <select wire:model="userSelects.{{ $index }}"
                                                name="userSelects[{{ $index }}]" id="user-{{ $index }}"
                                                class="form-control">
                                                <option value="">-- {{ __('ebps::ebps.select_user') }} --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user['id'] }}"
                                                        {{ in_array($user['id'], $userSelects) ? 'selected' : '' }}>
                                                        {{ $user['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div>
                                                @error("userSelects.$index")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group" wire:ignore>
                                            <label for="user_wards_{{ $index }}"
                                                class="form-label">{{ __('ebps::ebps.select_wards') }}</label>
                                            <select id="user_wards_{{ $index }}"
                                                name="selectedWards[{{ $index }}]"
                                                class="form-select select2-component" multiple style="width: 100%;"
                                                wire:model="selectedWards.{{ $index }}">
                                                @foreach ($wards as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error("selectedWards.$index")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end align-items-center mb-3">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeUser({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Form Submission Buttons -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ebps::ebps.save') }}</button>
        <a href="{{ route('admin.ebps.map_pass_groups.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
    </div>
</form>


@script
    <script>
        $wire.on('add-user', (index) => {

            $(document).ready(function() {
                const wardsSelect = $(`#user_wards_${index}`);
                console.log("Initializing Select2 for:", wardsSelect);

                wardsSelect.select2({
                    placeholder: "{{ __('ebps::ebps.select_wards') }}"
                });

                wardsSelect.on('change', function() {
                    const selectedWards = $(this).val();
                    @this.set(`selectedWards.${index}`, selectedWards);
                });
            });
        });
    </script>
@endscript
