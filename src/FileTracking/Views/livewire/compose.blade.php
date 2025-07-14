<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label" for="title">{{ __('filetracking::filetracking.title') }}</label>
                    <input wire:model.defer="fileRecord.title" name="fileRecord.title" type="text"
                        class="form-control {{ $errors->has('fileRecord.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('fileRecord.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.enter_title') }}">
                    @error('fileRecord.title')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('filetracking::filetracking.recepient_information') }}</div>
            </div>

            <div class="row" wire:ignore>
                <label class="form-label" type="departments">{{ __('filetracking::filetracking.recepient') }}</label>
                <x-form.select :options="$recepientDepartment" multiple name="selectedReceipents"
                    wireModel="selectedReceipents" placeholder="Select Recepient" />
            </div>

            <div class="col-md-12 my-3">
                <div class="form-group">
                    <label class="form-label" for="file">{{ __('filetracking::filetracking.file') }}</label>
                    <input wire:model.defer="uploadedFiles" name="file" type="file" class="form-control"
                        placeholder="Enter File" accept=".jpg,.jpeg,.png">
                    @error('uploadedFiles')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                    @if ($uploadedFiles)
                        <div class="row">
                            @foreach ($uploadedFiles as $image)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Uploaded Image Preview"
                                        class="img-thumbnail w-100 " style="height: 150px; object-fit: cover;" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>



            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label" for="fileRecord_body">{{ __('filetracking::filetracking.document_body') }}</label>
                    <textarea wire:model.defer="fileRecord.body" name="fileRecord.body" id="fileRecord_body" rows="4"
                        class="form-control {{ $errors->has('fileRecord.body') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('filetracking::filetracking.enter_document_details_here') }}"></textarea>

                    @error('fileRecord.body')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('filetracking::filetracking.save') }}</button>
        <a href="javascript:window.history.back();" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('filetracking::filetracking.back') }}</a>
    </div>
</form>


@script
<script>
    $(document).ready(function () {
        const recipientDepartment = $('#recipient_department')
        const signeeDepartment = $('#signee_department')

        recipientDepartment.select2()
        signeeDepartment.select2()

        recipientDepartment.on('change', function () {
            @this.set('fileRecord.recipient_department', $(this).val())

            @this.call('recipientDepartmentUser')
        })

        signeeDepartment.on('change', function () {
            @this.set('fileRecord.signee_department', $(this).val())
            @this.call('signeeDepartmentUser')
        })
    })
</script>
@endscript