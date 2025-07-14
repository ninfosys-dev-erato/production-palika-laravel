<form wire:submit.prevent="search">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">{{ __('Registerd Business Report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click = "export" class="btn btn-outline-primary btn-sm">
                {{ __('Export') }}
            </button>
            <button type="button" wire:click = "downloadPdf" class="btn btn-outline-primary btn-sm">
                {{ __('PDF') }}
            </button>
        </div>
    </div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-4">{{ __('Search') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!-- Input Fields -->

                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Start Date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="startDate" id="start_date"
                                class="form-control border-start-0 nepali-date" placeholder="{{ __('Start Date') }}">
                            {{-- <input type="date" class="form-control border-start-0" placeholder="Enter starting date"
                                wire:model="startDate"> --}}
                        </div>
                    </div>

                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('End Date') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-time"></i>
                            </span>
                            <input type="text" wire:model="endDate" id="end_date"
                                class="form-control border-start-0 nepali-date" placeholder="{{ __('End Date') }}">
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Business Category') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedCategory">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($categories as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Business Nature') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedNature">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($natures as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Business Type') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedType">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($types as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-items-center mt-3">
                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Ward') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select" wire:model="selectedWard">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($wards as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Application Status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select"
                                wire:model="selectedApplicationStatus">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($applicationStatus as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md col-12">
                        <label for="" class="form-label">{{ __('Business Status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bx bx-layer"></i>
                            </span>
                            <select name="" id="" class="form-select"
                                wire:model="selectedBusinessStatus">
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach ($businessStatus as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">


                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                            wire:target="search">
                            <span wire:loading wire:target="search">
                                <i class="bx bx-loader bx-spin me-1"></i>
                            </span>
                            <span wire:loading.remove wire:target="search">
                                <i class="bx bx-search me-1"></i> {{ __('Search') }}
                            </span>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                            <i class="bx bx-x-circle me-1"></i> {{ __('Clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($registerBusinessData && $registerBusinessData->count())
        <div class="container mt-4">
            <div class="card shadow table-responsive" id="printContent">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>क्र.स.</th>
                            <th>रजिस्ट्रेसन न</th>
                            <th>संस्थाको नाम</th>
                            <th>संस्थाको ठेगाना</th>
                            <th>प्रकार</th>
                            <th>वर्ग</th>
                            <th>प्रकृति</th>
                            <th>संस्थापकको नाम</th>
                            <th>संस्थापकको न</th>
                            <th>दर्ता मिती</th>
                            <th>आवेदन स्थिति</th>
                            <th>व्यापार स्थिति</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registerBusinessData as $data)
                            <tr>
                                <td>{{ replaceNumbers($loop->iteration, true) }}</td>
                                <td>{{ $data->registration_number }}</td>
                                <td>{{ $data->entity_name }}</td>
                                <td>
                                    {{ $data->province->title ?? '' }}
                                    {{ $data->district->title ?? '' }}
                                    {{ $data->localBody->title ?? '' }}
                                    {{ $data->ward_no ? ' वडा नं. ' . $data->ward_no : '' }}
                                </td>
                                <td>{{ $data->registrationType->registrationCategory->title_ne ?? '' }}</td>
                                <td>{{ $data->registrationType->title ?? '' }}</td>
                                <td>{{ $data->businessNature->title_ne ?? '' }}</td>
                                <td>{{ $data->applicant_name }}</td>
                                <td>{{ $data->applicant_number }}</td>
                                <td>{{ $data->application_date }}</td>
                                <td>{{ $data->application_status_nepali }}</td> {{-- convert enum to nepali from model --}}
                                <td>{{ $data->business_status_nepali }}</td>{{-- convert enum to nepali from model --}}

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
                <h5 class="text-center">{{ __('No Data To Show') }}</h5>

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
