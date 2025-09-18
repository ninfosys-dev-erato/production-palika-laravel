<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="form-group">
                    <label for="title">{{ __('filetracking::filetracking.chalani_title') }}</label>
                    <input wire:model.defer="fileRecord.title" name="fileRecord.title" type="text"
                        class="form-control {{ $errors->has('fileRecord.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.chalani_enter_title') }}">
                    @error('fileRecord.title')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 ">
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
                    <label for="fiscal_year">{{ __('filetracking::filetracking.letter_number') }}</label>
                    <select wire:model.defer="fileRecord.fiscal_year" name="fiscal_year" type="text" id="reg_date"
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

            <div class="col-12 mt-3">
                <hr>
                <h5>{{ __('filetracking::filetracking.recepient_information') }}</h5>
            </div>

            {{-- @if ($action === App\Enums\Action::CREATE)
                <div class="col-md-12 mt-3 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isReceipent" wire:click="toggleReceipent">
                        <label class="form-check-label"
                            for="isReceipent">{{ __('filetracking::filetracking.select_available_recepient') }}</label>
                    </div>
                </div>
            @endif --}}

            @if (!$isReceipent)
                <div class="col-md-6 mt-3">
                    <div class="form-group" wire:ignore>
                        <label for="recipient_department">{{ __('filetracking::filetracking.recepient') }}</label>
                        <select wire:model.defer="fileRecord.recipient_department" wire:change="recipientDepartmentUser"
                            id="recipient_department" name="fileRecord.recipient_department"
                            class="form-control {{ $errors->has('fileRecord.recipient_department') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.recipient_department') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            required>
                            <option value="">{{ __('filetracking::filetracking.select_a_department') }}
                            </option>
                            @foreach ($recepientDepartment as $receipent)
                                <option value="{{ $receipent['type'] . '_' . $receipent['model']->id }}">
                                    {{ $receipent['name'] }}</option>
                            @endforeach
                        </select>

                        @php
                            $errorMsg = $errors->first('fileRecord.recipient_department');
                        @endphp
                        @if ($errorMsg)
                            <small class="text-danger">{{ $errorMsg }}</small>
                        @endif
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="recipient_user">{{ __('filetracking::filetracking.recipient') }}</label>
                        <select wire:model="fileRecord.recipient_name" name="recipient_user"
                            class="form-control {{ $errors->has('fileRecord.recipient_name') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.recipient_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:change="recipientUserPosition">
                            <option value="">{{ __('filetracking::filetracking.select_a_user') }}</option>
                            @foreach ($recipientDepartmentUsers as $user)
                                <option value="{{ $user['name'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                        @php
                            $errorMsg = $errors->first('fileRecord.recipient_name');
                        @endphp
                        @if ($errorMsg)
                            <small class="text-danger">{{ $errorMsg }}</small>
                        @endif
                    </div>
                </div>

                {{-- <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label
                            for="recipient_position">{{ __('filetracking::filetracking.recipient_position') }}</label>
                        <input wire:model.defer="fileRecord.recipient_position" name="recipient_position" type="text"
                            class="form-control"
                            placeholder="{{ __('filetracking::filetracking.enter_recipient_position') }} " readonly>

                        @php
                            $errorMsg = $errors->first('fileRecord.recipient_position');
                        @endphp
                        @if ($errorMsg)
                            <small class="text-danger">{{ $errorMsg }}</small>
                        @endif

                    </div>
                </div> --}}
            @else
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="recipient_user">{{ __('filetracking::filetracking.recipient_user') }}</label>
                        <input wire:model="fileRecord.recipient_name" type="text" name="recipient_user"
                            id="recipient_user"
                            class="form-control {{ $errors->has('fileRecord.recipient_name') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.recipient_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_a_user_name') }}">
                        @error('fileRecord.recipient_name')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                {{-- <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label
                            for="recipient_position">{{ __('filetracking::filetracking.recipient_position') }}</label>
                        <input wire:model.defer="fileRecord.recipient_position" name="recipient_position"
                            id="recipient_position" type="text"
                            class="form-control {{ $errors->has('fileRecord.recipient_position') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_recipient_position') }}">
                        @error('fileRecord.recipient_position')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div> --}}
            @endif
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="recipient_position">{{ __('filetracking::filetracking.recipient_address') }}</label>
                    <input wire:model.defer="fileRecord.recipient_address" name="recipient_address"
                        id="recipient_position" type="text"
                        class="form-control {{ $errors->has('fileRecord.recipient_address') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.enter_recipient_address') }}">
                    @error('fileRecord.recipient_address')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <hr>
                <h5>{{ __('filetracking::filetracking.signee_information') }}</h5>
            </div>

            {{-- @if ($action === App\Enums\Action::CREATE)
                <div class="col-md-12 mt-3 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isSignee" wire:click="toggleSignee">
                        <label class="form-check-label"
                            for="isSignee">{{ __('filetracking::filetracking.select_available_signee') }}</label>
                    </div>
                </div>
            @endif --}}

            @if (!$isSignee)
                <div class="col-md-6">
                    <div class="form-group" wire:ignore>
                        <label for="signee_department">{{ __('filetracking::filetracking.signee') }}</label>
                        <select wire:model.defer="fileRecord.signee_department" name="fileRecord.signee_department"
                            id="signee_department"
                            class="form-control {{ $errors->has('fileRecord.signee_department') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.signee_department') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:change="signeeDepartmentUser" required>
                            <option value="">{{ __('filetracking::filetracking.select_a_signee') }}</option>
                            @foreach ($signeesDepartment as $signee)
                                <option value="{{ $signee['type'] . '_' . $signee['model']->id }}">
                                    {{ $signee['name'] }}</option>
                            @endforeach
                        </select>

                        @php
                            $errorMsg = $errors->first('fileRecord.signee_department');
                        @endphp
                        @if ($errorMsg)
                            <small class="text-danger">{{ $errorMsg }}</small>
                        @endif

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="signee_name">{{ __('filetracking::filetracking.signee_user') }}</label>
                        <select wire:model="fileRecord.signee_name" name="signee_name"
                            class="form-control {{ $errors->has('fileRecord.signee_name') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.signee_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            wire:change="signeeUserPosition">
                            <option value="">{{ __('filetracking::filetracking.select_a_user') }}</option>
                            @foreach ($signeeDepartmentUsers as $user)
                                <option value="{{ $user['name'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                        @php
                            $errorMsg = $errors->first('fileRecord.signee_name');
                        @endphp
                        @if ($errorMsg)
                            <small class="text-danger">{{ $errorMsg }}</small>
                        @endif
                    </div>
                </div>

                <div class="col-md-6 mb-3 mt-3">
                    <div class="form-group">
                        <label for="signee_position">{{ __('filetracking::filetracking.signee_position') }}</label>
                        <input wire:model.defer="fileRecord.signee_position" name="signee_position" type="text"
                            class="form-control"
                            placeholder="{{ __('filetracking::filetracking.enter_signee_position') }}">
                        @php
                            $errorMsg = $errors->first('fileRecord.signee_position');
                        @endphp
                        @if ($errorMsg)
                            <small class="text-danger">{{ $errorMsg }}</small>
                        @endif
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="signee_department">{{ __('filetracking::filetracking.signee') }}</label>
                        <input type="text" wire:model.defer="fileRecord.signee_department"
                            name="fileRecord.signee_department"
                            class="form-control {{ $errors->has('fileRecord.signee_department') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.signee_department') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_a_signee') }}">
                        @error('fileRecord.signee_department')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="signee_name">{{ __('filetracking::filetracking.signee_user') }}</label>
                        <input type="text" wire:model="fileRecord.signee_name" name="signee_name"
                            class="form-control {{ $errors->has('fileRecord.signee_name') ? 'is-invalid' : '' }}"
                            style="{{ $errors->has('fileRecord.signee_name') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_a_signee_user') }}">
                        @error('fileRecord.signee_name')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3 mt-3">
                    <div class="form-group">
                        <label for="signee_position">{{ __('filetracking::filetracking.signee_position') }}</label>
                        <input type="text" wire:model.defer="fileRecord.signee_position" name="signee_position"
                            id="signee_position"
                            class="form-control {{ $errors->has('fileRecord.signee_position') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('filetracking::filetracking.enter_signee_position') }}">
                        @error('fileRecord.signee_position')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            @endif
            <hr>
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

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="status">{{ __('filetracking::filetracking.sender_medium') }}</label>
                    <select id="status" name="fileRecord.sender_medium"
                        class="form-control {{ $errors->has('fileRecord.sender_medium') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.sender_medium') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        wire:model="fileRecord.sender_medium">
                        <option value="">{{ __('filetracking::filetracking.choose_sender_medium') }}</option>
                        @foreach (\Src\FileTracking\Enums\SenderMediumEnum::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('fileRecord.sender_medium')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            @if (!$hideDocumentType)
                <div class="col-md-6 mb-3">
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
        $(document).ready(function() {
            const recipientDepartment = $('#recipient_department')
            const signeeDepartment = $('#signee_department')

            recipientDepartment.select2()
            signeeDepartment.select2()

            recipientDepartment.on('change', function() {
                @this.set('fileRecord.recipient_department', $(this).val())

                @this.call('recipientDepartmentUser')
            })

            signeeDepartment.on('change', function() {
                @this.set('fileRecord.signee_department', $(this).val())
                @this.call('signeeDepartmentUser')
            })
        })
    </script>
@endscript
