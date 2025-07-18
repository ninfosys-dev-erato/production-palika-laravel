<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('grantmanagement::grantmanagement.grant_release_report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm">
                {{ __('grantmanagement::grantmanagement.export') }}
            </button>
            <button wire:click='downloadPdf' class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('grantmanagement::grantmanagement.pdf') }}
            </button>
        </div>
    </div>

    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('grantmanagement::grantmanagement.search') }}</div>
            </div>

            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md col-12">
                        <label for="start_date" class="form-label">
                            {{ __('grantmanagement::grantmanagement.start_date') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="start_date" id="start_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('grantmanagement::grantmanagement.start_date') }}">
                        </div>
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md col-12">
                        <label for="end_date" class="form-label">
                            {{ __('grantmanagement::grantmanagement.end_date') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="end_date" id="end_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('grantmanagement::grantmanagement.end_date') }}">
                        </div>
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md col-12">
                        <label for="grantee_type" class="form-label">
                            {{ __('grantmanagement::grantmanagement.grantee_type') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select id="grantee_type" class="form-select" multiple>
                                @foreach (\Src\GrantManagement\Enums\GranteeTypesEnum::cases() as $grateeTypes)
                                    <option value="{{ $grateeTypes->value }}">{{ $grateeTypes->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedWards')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">
                        <button wire:click="showRelativeData" class="btn btn-primary btn-sm">
                            <i class="bx bx-search me-1"></i> {{ __('grantmanagement::grantmanagement.search') }}
                        </button>
                        <button wire:click="clearRelativeData" class="btn btn-danger btn-sm">
                            <i class="bx bx-x-circle me-1"></i> {{ __('grantmanagement::grantmanagement.clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto mx-auto">

            @if (!empty($filtered_datas))
                <div class="container mt-4">
                    <div class="card mx-auto shadow">
                        <table class=" min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border">कार्यक्रम/क्रियाकलाप</th>
                                    <th class="py-2 px-4 border">अनुदानग्राही नाम</th>
                                    <th class="py-2 px-4 border"> अनुदानग्राही लगानी</th>
                                    <th class="py-2 px-4 border">नयाँ/निरन्तर</th>
                                    <th class="py-2 px-4 border">योजना स्थल</th>
                                    <th class="py-2 px-4 border">सम्पर्क नम्बर</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filtered_datas as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border">{{ $data->grantProgram?->program_name }}</td>
                                        <td class="py-2 px-4 border">{{ $data->grantee_name }}</td>
                                        <td class="py-2 px-4 border">{{ $data->investment }}</td>
                                        <td class="py-2 px-4 border">{{ $data->is_new_or_ongoing }}</td>
                                        <td class="py-2 px-4 border">{{ $data->location }}</td>
                                        <td class="py-2 px-4 border">{{ $data->contact_person }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="container mt-4">
                    <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                        style="height: 200px;">
                        <h5 class="text-center">{{ __('grantmanagement::grantmanagement.no_data_to_show') }}</h5>

                        @error('startDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror

                        @error('endDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
        </div>
        @endif
    </div>


    @push('scripts')
        <script>
            $('#selectedUser').select2().on('change', function(e) {
                @this.set('selectedUsers', $(this).val());
            });

            $('#grantee_type').select2().on('change', function(e) {
                @this.set('selectedGranteeType', $(this).val());
            });

            window.addEventListener('toast:error', event => {
                alert(event.detail.message);
            });
        </script>
    @endpush

</div>
