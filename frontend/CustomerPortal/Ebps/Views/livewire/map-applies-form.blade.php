<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">

            @if ($action === App\Enums\Action::UPDATE)
                <div class='col-md-4 mb-3'>
                    <label class="form-label" for="name">{{ __('Submission NUmber') }}</label>
                    <input type="text" readonly class="form-control" value="{{ $mapApply->submission_id }}">
                </div>
            @endif

            <div class='col-md-4 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='applied_date'>{{ __('Applied Date') }}</label>
                    <input wire:model='mapApply.applied_date' id="applied_date" name='applied_date' type='text'
                        class='nepali-date form-control' placeholder='{{ __('ebps::ebps.enter_applied_date') }}'>
                    <div>
                        @error('mapApply.applied_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <div class="form-group">
                        <label class="form-label" for="organization">{{ __('Select Organization') }}</label>
                        <select wire:model="mapApplyDetail.organization_id" class="form-control" id="organization">
                            <option value="">{{ __('ebps::ebps.select_organization') }}</option>
                            @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->org_name_ne }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.customer_detail') }}</div>
            </div>

            <div class='col-md-12 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='signature'>{{ __('ebps::ebps.signature') }}</label>
                    <input wire:model="uploadedImage" name="uploadedImage" type="file"
                        class="form-control {{ $errors->has('uploadedImage') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('uploadedImage2') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        accept="image/*,.pdf">
                    <div>
                        @error('uploadedImage')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                        @if (
                            ($uploadedImage && $uploadedImage instanceof \Livewire\TemporaryUploadedFile) ||
                                $uploadedImage instanceof \Illuminate\Http\File ||
                                $uploadedImage instanceof \Illuminate\Http\UploadedFile)
                            <a href="{{ $uploadedImage->temporaryUrl() }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @elseif (!empty(trim($uploadedImage)))
                            <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $uploadedImage, 'local', 'tempUrl') }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i>
                                {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.land_details') }}</div>
            </div>

            <div class="col-md-6 mb-4">
                <label for="former_local_body">{{ __('ebps::ebps.former_local_body') }}</label>
                <select id="former_local_body" wire:model="customerLandDetail.former_local_body"
                    name="customerLandDetail.former_local_body" class="form-control" wire:change="loadFormerWards">

                    <option value="">{{ __('ebps::ebps.choose_former_local_body') }}</option>

                    @foreach ($formerLocalBodies as $id => $title)
                        <option value="{{ $id }}">{{ $title }}
                        </option>
                    @endforeach
                </select>
                @error('customerLandDetail.former_local_body')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label for="former_ward_no">{{ __('ebps::ebps.former_ward_no') }}</label>
                <select id="former_ward_no" name="customerLandDetail.former_ward_no" class="form-control"
                    wire:model="customerLandDetail.former_ward_no">
                    <option value="">{{ __('ebps::ebps.choose_former_ward_no') }}</option>
                    @foreach ($formerWards as $id => $title)
                        <option value="{{ $title }}">{{ $title }}
                        </option>
                    @endforeach
                </select>
                @error('customerLandDetail.former_ward_no')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="local_body_id">{{ __('ebps::ebps.local_body') }}</label>
                    <select id="local_body_id" wire:model="customerLandDetail.local_body_id"
                        name="customerLandDetail.local_body_id" class="form-control" wire:change="loadWards">

                        <option value="">{{ __('ebps::ebps.choose_local_body') }}</option>

                        @foreach ($localBodies as $id => $title)
                            <option value="{{ $id }}">{{ $title }}
                            </option>
                        @endforeach
                    </select>
                    @error('customerLandDetail.local_body_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-6 mb-4">
                    <label for="ward_id">{{ __('ebps::ebps.ward') }}</label>
                    <select id="ward_id" name="customerLandDetail.ward" class="form-control"
                        wire:model="customerLandDetail.ward">
                        <option value="">{{ __('ebps::ebps.choose_ward') }}</option>
                        @foreach ($wards as $id => $title)
                            <option value="{{ $title }}">{{ $title }}
                            </option>
                        @endforeach
                    </select>
                    @error('customerLandDetail.ward')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='tole'>{{ __('ebps::ebps.tole') }}</label>
                        <input wire:model='customerLandDetail.tole' name='tole' type='text' class='form-control'
                            placeholder="{{ __('ebps::ebps.enter_tole') }}">
                        <div>
                            @error('customerLandDetail.tole')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='area_sqm'>{{ __('ebps::ebps.area_sqm') }}</label>
                        <input wire:model='customerLandDetail.area_sqm' name='area_sqm' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_area_sqm') }}">
                        <div>
                            @error('customerLandDetail.area_sqm')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='lot_no'>{{ __('ebps::ebps.lot_no') }}</label>
                        <input wire:model='customerLandDetail.lot_no' name='lot_no' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_lot_no') }}">
                        <div>
                            @error('customerLandDetail.lot_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='seat_no'>{{ __('ebps::ebps.seat_no') }}</label>
                        <input wire:model='customerLandDetail.seat_no' name='seat_no' type='text'
                            class='form-control' placeholder="{{ __('ebps::ebps.enter_seat_no') }}">
                        <div>
                            @error('customerLandDetail.seat_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='ownership'>{{ __('ebps::ebps.ownership') }}</label>
                        <select wire:model='customerLandDetail.ownership' name='ownership' class='form-control'>
                            <option value="">{{ __('ebps::ebps.select_ownership') }}</option>
                            @foreach ($ownerships as $ownership)
                                <option value="{{ $ownership->value }}">
                                    {{ $ownership->label() }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('customerLandDetail.ownership')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class=" d-flex justify-content-between mb-4">
                <label class="form-label" for="form-label">{{ __('ebps::ebps.four_boundaries') }}</label>
                <button type="button" class="btn btn-info" wire:click='addFourBoundaries'
                        {{ count($fourBoundaries) >= 4 ? 'disabled' : '' }}>
                    + {{ __('Add Four Boundaries') }}
                </button>
            </div>

            @foreach ($fourBoundaries as $index => $boundary)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='title'>{{ __('ebps::ebps.title') }}</label>
                                            <input wire:model='fourBoundaries.{{ $index }}.title'
                                                name='fourBoundaries.{{ $index }}.title' type='text'
                                                class='form-control'
                                                placeholder="{{ __('ebps::ebps.enter_title') }}">
                                        </div>
                                        <div>
                                            @error('fourBoundaries.{{ $index }}.title')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='direction'>{{ __('ebps::ebps.direction') }}</label>
                                            <select wire:model='fourBoundaries.{{ $index }}.direction'
                                                name='fourBoundaries.{{ $index }}.direction'
                                                class='form-control'>
                                                <option value="">
                                                    {{ __('ebps::ebps.select_direction') }}</option>
                                                @foreach ($this->getAvailableDirections($index) as $direction)
                                                    <option value="{{ $direction->value }}">
                                                        {{ $direction->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            @error('fourBoundaries.{{ $index }}.direction')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='distance'>{{ __('ebps::ebps.distance') }}</label>
                                            <input wire:model='fourBoundaries.{{ $index }}.distance'
                                                name='fourBoundaries.{{ $index }}.distance' type='text'
                                                class='form-control'
                                                placeholder="{{ __('ebps::ebps.enter_distance') }}">
                                        </div>
                                        <div>
                                            @error('fourBoundaries.{{ $index }}.distance')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class='col-md-3'>
                                        <div class='form-group'>
                                            <label for='lot_no'>{{ __('ebps::ebps.lot_no') }}</label>
                                            <input wire:model='fourBoundaries.{{ $index }}.lot_no'
                                                name='fourBoundaries.{{ $index }}.lot_no' type='text'
                                                class='form-control'
                                                placeholder="{{ __('ebps::ebps.enter_lot_no') }}">
                                        </div>
                                        <div>
                                            @error('fourBoundaries.{{ $index }}.lot_no')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end align-items-center mb-3">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeFourBoundaries({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text ">{{ __('ebps::ebps.details') }}</div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='construction_type_id'>{{ __('ebps::ebps.construction_type') }}</label>
                    <select wire:model='mapApply.construction_type_id' name='construction_type_id'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'>
                        <option value="" hidden>{{ __('Select Construction Type') }}</option>
                        @foreach ($constructionTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.construction_type_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='usage'>{{ __('ebps::ebps.usage') }}</label>
                    <select wire:model='mapApply.usage' name='usage' class='form-control'>
                        <option value="" hidden>{{ __('ebps::ebps.select_usage') }}</option>
                        @foreach ($usageOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapApply.usage')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text">{{ __('ebps::ebps.required_documents') }}</div>
            </div>

            @php
                $reindexedFiles = array_values($uploadedFiles);

            @endphp

            @foreach ($mapDocuments as $index => $document)
                @php
                    $filePath = $reindexedFiles[$index] ?? null;
                @endphp

                <div class="row">
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label class="form-label">{{ __('ebps::ebps.document_name') }}</label>
                            <input type="text" class="form-control" value="{{ $document->title }}" readonly>
                        </div>
                    </div>

                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label class="form-label">{{ __('ebps::ebps.upload_file') }}</label>
                            <input wire:model="uploadedFiles.{{ $index }}" type="file"
                                class="form-control {{ $errors->has('uploadedFiles.' . $index) ? 'is-invalid' : '' }}"
                                accept="image/*">
                            <div>
                                @error("uploadedFiles.$index")
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror

                                @if (isset($reindexedFiles[$index]) &&
                                        ($reindexedFiles[$index] instanceof \Livewire\TemporaryUploadedFile ||
                                            $reindexedFiles[$index] instanceof \Illuminate\Http\File ||
                                            $reindexedFiles[$index] instanceof \Illuminate\Http\UploadedFile))
                                    <img src="{{ $reindexedFiles[$index]->temporaryUrl() }}"
                                        alt="Uploaded Image Preview" class="img-thumbnail mt-2"
                                        style="height: 300px;">
                                @elseif (!empty($filePath))
                                    {{-- Show existing file if no new file is uploaded --}}
                                    <img src="{{ customAsset(config('src.Ebps.ebps.path'), $filePath) }}"
                                        alt="Existing Document Preview" class="img-thumbnail mt-2"
                                        style="height: 300px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($documents)

                <div class="divider divider-primary text-start text-primary font-14">
                    <div class="divider-text">{{ __('More Documents') }}</div>
                </div>

            @if ($openModal)
                <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('ebps::ebps.create_customer') }}</h5>
                                <button type="button" wire:click="closeCustomerKycModal"
                                    class="btn btn-light d-flex justify-content-center align-items-center shadow-sm"
                                    style="width: 40px; height: 40px; border: none; background-color: transparent;">
                                    <span style="color: red; font-size: 20px;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <livewire:customers.customer_form :$action :$isModalForm :isForGrievance="false" />
                            </div>
                        </div>

                <div class="col-md-12">
                    <div class="list-group">
                        @foreach ($documents as $key => $document)
                            <div class="list-group-item list-group-item-action py-3 px-4 rounded shadow-sm"
                                wire:key="doc-{{ $key }}">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.document_name') }}</label>
                                            <input
                                                dusk="businessregistration-documents.{{ $key }}.title-field"
                                                type="text" class="form-control"
                                                wire:model="documents.{{ $key }}.title"
                                                placeholder="Enter document name">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.upload_document') }}</label>
                                            <input type="file" class="form-control-file"
                                                wire:model.defer="documents.{{ $key }}.file">

                                            <div wire:loading wire:target="documents.{{ $key }}.file">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Uploading...
                                            </div>

                                            @if (isset($documents[$key]['url']) && !empty($documents[$key]['url']))
                                                <p>
                                                    <a href="{{ $documents[$key]['url'] }}" target="_blank">
                                                        <i class="bx bx-file"></i> {{ $documents[$key]['title'] }}
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" wire:target="documents.{{ $key }}.file">
                                        <div class="form-group">
                                            <label
                                                class="font-weight-bold">{{ __('ebps::ebps.document_status') }}</label>
                                            <select
                                                dusk="businessregistration-documents.{{ $key }}.status-field"
                                                wire:model.defer="documents.{{ $key }}.status"
                                                id="documents.{{ $key }}.status" class="form-control">
                                                @foreach ($options as $k => $v)
                                                    <option value="{{ $k }}">{{ $v }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="btn-group-vertical">
                                            <button class="btn btn-danger"
                                                wire:click="removeDocument({{ $key }})">
                                                <i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ __('ebps::ebps.save') }}</button>
        <a href="{{ route('customer.ebps.apply.map-apply.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#customer_id').select2({
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
                    return data.text;
                }
            }).on('select2:select', function(e) {
                @this.set('customer_id', $(this).select2("val"));
            });
        });
    </script>
@endpush
