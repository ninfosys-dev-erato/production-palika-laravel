<form wire:submit.prevent="search">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('tokentracking::tokentracking.register_file_report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click = "export" class="btn btn-outline-primary btn-sm">
                {{ __('tokentracking::tokentracking.export') }}
            </button>
            <button wire:click ='downloadPdf' class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('tokentracking::tokentracking.pdf') }}
            </button>
            <button wire:click ='branchCountPdf' class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('Branch Token Count PDF') }}
            </button>
            <button wire:click ='branchPurposeCountPdf' class="btn btn-outline-primary btn-sm" target="_blank">
                {{ __('Branch-Purpose Count PDF') }}
            </button>
        </div>
    </div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('tokentracking::tokentracking.search') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!-- Input Fields -->

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.start_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="startDate" id="start_date"
                                class="form-control border-start-0 nepali-date "
                                placeholder="{{ __('tokentracking::tokentracking.start_date') }}">
                            {{-- <input type="date" class="form-control border-start-0" placeholder="Enter starting date"
                                wire:model="startDate"> --}}
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.end_date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="endDate" id="end_date"
                                class="form-control border-start-0 nepali-date"
                                placeholder="{{ __('tokentracking::tokentracking.end_date') }}">
                        </div>
                    </div>
                    <div class="col-md col-12" wire:ignore>
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.department') }}</label>
                        <div class="input-group">
                            <select wire:model="selectedDepartment" id="selectedDepartment" class="form-select"
                                multiple>
                                @foreach ($departments as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.token_stage') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            {{-- <input type="text" wire:model="selectedStage" class="form-control border-start-0"
                                placeholder="{{ __('Stage') }}"> --}}
                            <select wire:model="selectedStage" class="form-select">
                                <option value=""hidden>{{ __('tokentracking::tokentracking.select_an_option') }}
                                </option>
                                @foreach ($stage as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.token_status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>

                            <select wire:model="selectedStatus" class="form-select">
                                <option value=""hidden>{{ __('tokentracking::tokentracking.select_an_option') }}
                                </option>
                                @foreach ($status as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Buttons Group -->

                </div>
                <div class="row g-3 align-items-center mt-3">
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.citizen_satisfaction') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>

                            <select wire:model="selectedCitizen" class="form-select">
                                <option value=""hidden>{{ __('tokentracking::tokentracking.select_an_option') }}
                                </option>
                                @foreach ($citizenSatisfaction as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.service_accessibility') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>

                            <select wire:model="selectedAccessibility" class="form-select">
                                <option value=""hidden>{{ __('tokentracking::tokentracking.select_an_option') }}
                                </option>
                                @foreach ($serviceAccesibility as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.service_quality') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>

                            <select wire:model="selectedQuality" class="form-select">
                                <option value=""hidden>{{ __('tokentracking::tokentracking.select_an_option') }}
                                </option>
                                @foreach ($serviceQuality as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for=""
                            class="form-label">{{ __('tokentracking::tokentracking.purpose') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>

                            <select wire:model="selectedPurpose" class="form-select">
                                <option value=""hidden>{{ __('tokentracking::tokentracking.select_an_option') }}
                                </option>
                                @foreach ($purpose as $englishValue => $nepaliLabel)
                                    <option value="{{ $englishValue }}">{{ $nepaliLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-6">
                        <label>{{ __('Signee') }}</label>
                        <livewire:signee-select />
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bx bx-search me-1"></i> {{ __('tokentracking::tokentracking.search') }}
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                            <i class="bx bx-x-circle me-1"></i> {{ __('tokentracking::tokentracking.clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto mx-auto">
        @if ($registerTokenData && $registerTokenData->count())
            <div class="container mt-4">
                <div class="card mx-auto shadow">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">टोकन</th>
                                <th class="py-2 px-4 border">ग्राहक</th>
                                <th class="py-2 px-4 border">मिति</th>
                                <th class="py-2 px-4 border">स्थिति</th>
                                <th class="py-2 px-4 border">प्रतिक्रिया</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registerTokenData as $token)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border">
                                        टोकन: {{ $token->token }}<br>
                                        उद्देश्य: {{ $token->token_purpose_label }}<br>
                                        शाखा: {{ $token->currentBranch->title ?? 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        @if ($token->tokenHolder)
                                            {{ $token->tokenHolder->name }}<br>
                                            <small>{{ $token->tokenHolder->mobile_no }}</small><br>
                                            <small>{{ $token->tokenHolder->address }}</small>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border">
                                        {{ $token->created_at_bs }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        चरण:
                                        {{ Src\TokenTracking\Enums\TokenStageEnum::from($token->stage)->label() }} <br>
                                        स्थिति:
                                        {{ Src\TokenTracking\Enums\TokenStatusEnum::from($token->status)->label() }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        @if ($token->feedback->isNotEmpty())
                                            गुणस्तर:
                                            {{ Src\TokenTracking\Enums\ServiceQualityEnum::from($token->feedback->first()->service_quality)->label() }}
                                            <br>
                                            पहुँचयोग्यता:
                                            {{ Src\TokenTracking\Enums\ServiceAccesibilityEnum::from($token->feedback->first()->service_accesibility)->label() }}
                                            <br>
                                            सन्तुष्टि:
                                            {{ Src\TokenTracking\Enums\CitizenSatisfactionEnum::from($token->feedback->first()->citizen_satisfaction)->label() }}
                                        @else
                                            कुनै प्रतिक्रिया उपलब्ध छैन
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="container mt-4">
                    <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                        style="height: 200px;">
                        <h5 class="text-center">{{ __('tokentracking::tokentracking.no_data_to_show') }}</h5>

                        @error('startDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror

                        @error('endDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

        @endif

</form>
@script
    <script>
        $('#selectedDepartment').select2().on('change', function(e) {
            @this.set('selectedDepartment', $(this).val());
        });
    </script>
@endscript
