<form wire:submit.prevent="save">

    <div class="card-body">
        <div class="row">
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('Received Letter') }}</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="registration_date">{{ __('filetracking::filetracking.registration_date') }}</label>
                    <input wire:model.defer="fileRecord.registration_date" name="registration_date" type="text"
                        id="reg_date"
                        class="nepali-date form-control {{ $errors->has('fileRecord.registration_date') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.registration_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.registration_date') }}">
                    @error('fileRecord.registration_date')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="received_date">{{ __('filetracking::filetracking.received_date') }}</label>
                    <input wire:model.defer="fileRecord.received_date" name="received_date" type="text"
                        id="received_date"
                        class="nepali-date form-control {{ $errors->has('fileRecord.received_date') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.received_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.received_date') }}">
                    @error('fileRecord.received_date')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fiscal_year">{{ __('filetracking::filetracking.letter_number') }}</label>
                    <select wire:model.defer="fileRecord.fiscal_year" name="fiscal_year" type="text" id="fiscal_year"
                        class="form-control {{ $errors->has('fileRecord.fiscal_year') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.fiscal_year') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.fiscal_year') }}">
                        <option value=""> {{ __('Select an option') }}</option>
                        @foreach ($fiscalYears as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('fileRecord.fiscal_year')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label
                        for="sender_document_number">{{ __('filetracking::filetracking.sender_document_number') }}</label>
                    <input wire:model.defer="fileRecord.sender_document_number" name="sender_document_number"
                        type="text" id="sender_document_number"
                        class="form-control {{ $errors->has('fileRecord.sender_document_number') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.sender_document_number') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.sender_document_number') }}">
                    @error('fileRecord.sender_document_number')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('Letter Details') }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="title">{{ __('filetracking::filetracking.darta_title') }}</label>
                    <input wire:model.defer="fileRecord.title" name="fileRecord.title" type="text"
                        class="form-control {{ $errors->has('fileRecord.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.enter_title') }}">
                    @error('fileRecord.title')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            {{-- @if ($action === App\Enums\Action::CREATE)
                <div class="col-md-12 mt-3 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isCustomer" wire:click="toggleCustomer">
                        <label class="form-check-label"
                            for="isCustomer">{{ __('filetracking::filetracking.is_customer_') }}</label>
                    </div>
                </div>
            @endif --}}
            @if (!$isCustomer)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="applicant_name">{{ __('filetracking::filetracking.applicant_name') }}</label>
                        <input wire:model.defer="fileRecord.applicant_name" name="applicant_name" type="text"
                            class="form-control {{ $errors->has('fileRecord.applicant_name') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.applicant_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_applicant_name') }}">
                        @error('fileRecord.applicant_name')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label
                            for="applicant_mobile_no">{{ __('filetracking::filetracking.applicant_mobile_no') }}</label>
                        <input wire:model.defer="fileRecord.applicant_mobile_no" name="applicant_mobile_no"
                            type="text"
                            class="form-control {{ $errors->has('fileRecord.applicant_mobile_no') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.applicant_mobile_no') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_applicant_mobile_no') }}">
                        @error('fileRecord.applicant_mobile_no')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="applicant_address">{{ __('filetracking::filetracking.applicant_address') }}</label>
                        <input wire:model.defer="fileRecord.applicant_address" name="applicant_address" type="text"
                            class="form-control {{ $errors->has('fileRecord.applicant_address') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.applicant_address') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_applicant_address') }}">
                        @error('fileRecord.applicant_address')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            @elseif($isCustomer)
                <div class="row">
                    <div class="col-md-10 mb-3" wire:ignore>
                        @if ($action === App\Enums\Action::CREATE)
                            <x-form.select-input label="{{ __('filetracking::filetracking.customer') }}"
                                id="applicant_id" name="applicant_id" wire:model="applicant_id"
                                placeholder="{{ __('filetracking::filetracking.choose_customer') }}" />
                        @elseif($action === App\Enums\Action::UPDATE)
                            <label for="name">{{ __('filetracking::filetracking.customer') }}</label>
                            <input type="text" readonly class="form-control"
                                value="{{ $this->fileRecord->applicant_name . ' ( ' . $this->fileRecord->applicant_mobile_no . ' ) ' }}">
                        @endif
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="form-control" style="margin-top: 20px; width:20%"
                            wire:click="openCustomerKycModal">
                            +</button>
                    </div>
                </div>
            @endif

            <div class="col-md-6" wire:ignore>
                <label class="form-label" type="departments">{{ __('filetracking::filetracking.receiver_') }}</label>
                <x-form.select :options="$recepientDepartment" name="selectedReceipents" wireModel="selectedDepartments"
                    placeholder="Select Recepient" />
            </div>
            <div class="col-md-6" wire:ignore>
                <label class="form-label" type="departments">{{ __('filetracking::filetracking.farsuyat_') }}</label>
                <x-form.select :options="$recepientDepartment" name="farsuyat" wireModel="farsuyat"
                    placeholder="Select Farsuyat" />
            </div>

            @if (!$hideDocumentType)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="document_level">{{ __('filetracking::filetracking.document_level') }}</label>
                        <select wire:model.defer="fileRecord.document_level" name="document_level"
                            class="form-control {{ $errors->has('fileRecord.document_level') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.document_level') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}">
                            <option value="">{{ __('filetracking::filetracking.select_document_level') }}
                            </option>
                            <option value="palika">{{ __('filetracking::filetracking.palika') }}</option>
                            <option value="ward">{{ __('filetracking::filetracking.ward_level') }}</option>
                        </select>
                        @error('fileRecord.document_level')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="file">{{ __('filetracking::filetracking.file') }}</label>
                    <input wire:model.defer="uploadedFiles" name="file" type="file" class="form-control"
                        multiple>
                    @error('uploadedFiles')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                    @if ($uploadedFiles)
                        <div class="row mt-3">
                            @foreach ($uploadedFiles as $file)
                                @php
                                    $mime = $file->getMimeType();
                                    $isImage = str_starts_with($mime, 'image/');
                                    $isPDF = $mime === 'application/pdf';
                                @endphp

                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    @if ($isImage)
                                        <img src="{{ $file->temporaryUrl() }}" alt="Image Preview"
                                            class="img-thumbnail w-100" style="height: 150px; object-fit: cover;" />
                                    @elseif ($isPDF)
                                        <div class="border rounded p-3 d-flex align-items-center"
                                            style="height: 60px;">
                                            <i class="fas fa-file-alt fa-lg text-primary me-2"></i>
                                            <a href="{{ $file->temporaryUrl() }}" target="_blank"
                                                class="text-primary fw-bold text-decoration-none">
                                                {{ __('अपलोड गरिएको फाइल हेर्नुहोस्') }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="border p-2 text-center" style="height: 150px;">
                                            <p class="mb-1">Unsupported File</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @elseif (!empty($this->fileRecord->file))
                        @php
                            $fileList = is_string($this->fileRecord->file)
                                ? json_decode($this->fileRecord->file, true)
                                : $this->fileRecord->file;
                        @endphp

                        @if (!empty($fileList) && is_array($fileList))
                            @foreach ($fileList as $file)
                                @php
                                    $fileUrl = customFileAsset(
                                        config('src.FileTracking.fileTracking.file'),
                                        $file,
                                        'local',
                                        'tempUrl',
                                    );
                                @endphp

                                <a href="{{ $fileUrl }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm mb-1">
                                    <i class="bx bx-file"></i>
                                    {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('filetracking::filetracking.save') }}</button>
        <a href="javascript:window.history.back();" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('filetracking::filetracking.back') }}</a>
    </div>
</form>


@script
    <script>
        $wire.on('init-select2', () => {
            $(document).ready(function() {
                $('#applicant_id').select2({
                    ajax: {
                        url: function(params) {
                            let client_href =
                                '{{ parse_url(url()->route('customers.search'), PHP_URL_PATH) }}';
                            let query = [];
                            if (params.term) {
                                if (/^\d+$/.test(params.term)) {
                                    query.push('filter[mobile_no]=' + params.term);
                                } else {
                                    query.push('filter[name]=' + params.term);
                                }
                            }
                            if (query.length > 0) {
                                client_href += '?' + query.join('&');
                            }
                            return client_href;
                        },
                        delay: 250,
                        processResults: function(data) {
                            let selectOptions = [];
                            selectOptions.push({
                                id: '',
                                text: 'All Customers'
                            });
                            $.each(data.data, function(v, r) {
                                let option_name = r.mobile_no + ' (' + r.name + ')';
                                let obj = {
                                    id: r.id,
                                    text: option_name
                                };
                                selectOptions.push(obj);
                            });

                            return {
                                results: selectOptions
                            };
                        }
                    },
                    templateSelection: function(data) {
                        @this.set('applicant_id', data.id);
                        return data.text;
                    }
                });
                @this.on('customerIdUpdated', customerId => {
                    $('#applicant_id').val(customerId).trigger('change');
                });
            });

        });
    </script>
@endscript
