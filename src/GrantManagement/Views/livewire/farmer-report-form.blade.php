<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('grantmanagement::grantmanagement.farmer_reports') }}</h4>
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
                        <label for="selctedWard" class="form-label">
                            {{ __('grantmanagement::grantmanagement.province') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <select id="province_id" class="form-select" multiple>
                                @foreach ($proviences as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedWards')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="mt-1 row g-3 align-items-center">
                    <div class="col-md col-12">
                        <label for="ward_id"
                            class="form-label">{{ __('grantmanagement::grantmanagement.ward') }}</label>
                        <div class="input-group" wire:ignore>
                            <select id="ward_id" class="form-select" multiple>
                                @foreach ($wards as $id => $ward_name_ne)
                                    <option value="{{ $id }}">{{ $ward_name_ne }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for="local_body_id"
                            class="form-label">{{ __('grantmanagement::grantmanagement.local_body') }}</label>
                        <div class="input-group" wire:ignore>
                            <select id="local_body_id" class="form-select" multiple>
                                @foreach ($localBodies as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for="involved_group_id"
                            class="form-label">{{ __('grantmanagement::grantmanagement.group') }}</label>
                        <div class="input-group" wire:ignore>
                            <select id="involved_group_id" class="form-select" multiple>
                                @foreach ($involvedGroups as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for="involved_enterprise_id"
                            class="form-label">{{ __('grantmanagement::grantmanagement.enterprise') }}</label>
                        <div class="input-group" wire:ignore>
                            <select id="involved_enterprise_id" class="form-select" multiple>
                                @foreach ($involvedEnterprise as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for="involved_cooperative_id"
                            class="form-label">{{ __('grantmanagement::grantmanagement.cooperative') }}</label>
                        <div class="input-group" wire:ignore>
                            <select id="involved_cooperative_id" class="form-select" multiple>
                                @foreach ($involvedCooperative as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                                    <th class="py-2 px-4 border">परिचय पत्र नं.</th>
                                    <th class="py-2 px-4 border">पुरा नाम</th>
                                    <th class="py-2 px-4 border">ठेगाना</th>
                                    <th class="py-2 px-4 border">कृषक सूचीकरण नं</th>
                                    <th class="py-2 px-4 border">नागरिकता नं</th>
                                    <th class="py-2 px-4 border">सम्पर्क नं.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filtered_datas as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border">{{ $data->national_id_card_no }}</td>
                                        <td class="py-2 px-4 border">
                                            {{ $data->user?->name }}
                                        </td>

                                        <td class="py-2 px-4 border">
                                            {{ collect([$data->province?->title, $data->district?->title, $data->ward?->ward_name_ne, $data->localBody?->title, $data->village, $data->tole])->filter()->join(' ') }}
                                        </td>
                                        <td class="py-2 px-4 border">{{ $data->farmer_id_card_no }}</td>
                                        <td class="py-2 px-4 border">{{ $data->phone_no }}</td>
                                        <td class="py-2 px-4 border">{{ $data->citizenship_no }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="container mt-4">
                    <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                        style="min-height: 200px;">
                        <h5 class="text-center">{{ __('grantmanagement::grantmanagement.no_data_to_show') }}</h5>

                        @error('startDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror

                        @error('endDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            @endif
        </div>

    </div>


    @push('scripts')
        <script>
            const selectBindings = {
                '#cooperative_id': 'cooperative_id',
                '#enterprise_id': 'enterprise_id',
                '#province_id': 'province_id',
                '#district_id': 'district_id',
                '#ward_id': 'ward_no',
                '#local_body_id': 'local_body_id',
                '#involved_group_id': 'group_id',
                '#involved_enterprise_id': 'enterprise_id',
                '#involved_cooperative_id': 'cooperative_id',
            };

            for (const [selector, livewireProp] of Object.entries(selectBindings)) {
                $(selector).select2().on('change', function() {
                    @this.set(livewireProp, $(this).val());
                });
            }

            window.addEventListener('toast:error', event => {
                alert(event.detail.message);
            });

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('clear-select2', () => {
                    $('#province_id').val(null).trigger('change');
                    $('#district_id').val(null).trigger('change');
                    $('#ward_id').val(null).trigger('change');
                    $('#local_body_id').val(null).trigger('change');
                    $('#involved_group_id').val(null).trigger('change');
                    $('#involved_enterprise_id').val(null).trigger('change');
                    $('#involved_cooperative_id').val(null).trigger('change');
                });
            });
        </script>
    @endpush


</div>
