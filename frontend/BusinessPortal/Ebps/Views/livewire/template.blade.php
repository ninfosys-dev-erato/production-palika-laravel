<div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-9">
        <div class="d-flex justify-content-between gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                @if ($this->activeFormId === 'custom')
                    <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled" wire:click="save">
                        <i class="bx bx-save"></i>
                        {{ __('ebps::ebps.save') }}
                    </button>
                @else
                    <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                        wire:click="writeAdditionalFormTemplate">
                        <i class="bx bx-save"></i>
                        {{ __('ebps::ebps.save') }}
                    </button>
                    <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                        wire:click="resetLetter">
                        <i class="bx bx-reset"></i>
                        {{ __('ebps::ebps.reset') }}
                    </button>
                    <!-- Toggle Preview/Edit Mode -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label mb-0" for="previewToggle">
                            {{ $preview ? __('ebps::ebps.preview') : __('ebps::ebps.edit') }}
                        </label>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" id="previewToggle" class="form-check-input"
                                style="width: 3rem; height: 1.3rem;" wire:model="editMode" wire:click="togglePreview">
                        </div>
                    </div>
                @endif
            </div>

            <a href="javascript:history.back()" class="btn btn-outline-primary">
                <i class="bx bx-arrow-back"></i> {{ __('Back') }}
            </a>
        </div>

    </div>


    <div class="row">
        <!-- Sidebar with tab navigation -->


        <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm">
                <ul class="nav flex-column nav-pills">

                    <li class="nav-item mb-2 d-flex align-items-center">
                        <button type="button"
                            class="nav-link {{ $activeFormId === 'custom' ? 'active' : '' }} flex-grow-1 text-start"
                            wire:click="switchToForm('custom')">
                            Additional Form
                        </button>
                        {{-- <span class="badge {{ $customFormSaved ? 'bg-success' : 'bg-warning text-dark' }} ms-2">
                            {{ $customFormSaved ? '✓' : '✗' }}
                        </span> --}}
                    </li>
                    @foreach ($additionalFormsTemplate as $formTemplate)
                        <li class="nav-item mb-2 d-flex align-items-center">
                            <button type="button"
                                class="nav-link {{ $activeFormId === $formTemplate['id'] ? 'active' : '' }} flex-grow-1 text-start"
                                wire:click="switchToForm({{ $formTemplate['id'] }})">
                                {{ $formTemplate['name'] }}
                            </button>
                            <span
                                class="badge {{ $formTemplate['is_saved'] ? 'bg-success' : 'bg-warning text-dark' }} ms-2">
                                {{ $formTemplate['is_saved'] ? '✓' : '✗' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


        <div class="col-md-9">

            @if ($activeFormId === 'custom')
                <form wire:submit.prevent="save">
                    <!-- Applicant Details Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-dark text-center fw-bold">
                                {{ __('Detail to be filled by consultancy') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">1. जग्गाधनीको नाम, जात:</label>
                                    <input type="text" class="form-control d-inline-block fw-bold"
                                        value="{{ $mapApply->full_name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">2. घरधनीको नाम, जात:</label>
                                    <input type="text" class="form-control d-inline-block fw-bold"
                                        value="{{ $mapApply->full_name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">3. भू-उपयोग क्षेत्र</label>
                                    <select
                                        class="form-select @error('mapApplyDetail.land_use_area_id') is-invalid @enderror"
                                        name="land_use_zone" wire:model="mapApplyDetail.land_use_area_id" required>
                                        <option value="">छानुहोस *</option>
                                        @foreach ($landUseAreas as $landUseArea)
                                            <option value="{{ $landUseArea->id }}">{{ $landUseArea->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mapApplyDetail.land_use_area_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">4. निर्माणको प्रयोजन</label>
                                    <select
                                        class="form-select @error('mapApplyDetail.construction_purpose_id') is-invalid @enderror"
                                        name="construction_purpose" wire:model="mapApplyDetail.construction_purpose_id">
                                        <option value="">छानुहोस *</option>
                                        @foreach ($constructionPurposes as $constructionPurpose)
                                            <option value="{{ $constructionPurpose['value'] }}">
                                                {{ $constructionPurpose['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mapApplyDetail.construction_purpose')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">5. प्रस्तावित निर्माणले विद्यमान उपभोगमा परिवर्तन
                                        गर्ने भए सोको
                                        विवरण</label>
                                    <input type="text"
                                        class="form-control @error('mapApplyDetail.land_use_area_changes') is-invalid @enderror"
                                        name="land_use_area_changes" wire:model="mapApplyDetail.land_use_area_changes"
                                        placeholder="५.१ भू-उपयोगमा परिवर्तन (विवरण)">
                                    @error('mapApplyDetail.land_use_area_changes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"></label>
                                    <input type="text"
                                        class="form-control @error('mapApplyDetail.usage_changes') is-invalid @enderror"
                                        name="usage_changes" wire:model="mapApplyDetail.usage_changes"
                                        placeholder="५.१ भू-उपयोगमा परिवर्तन (विवरण)">
                                    @error('mapApplyDetail.usage_changes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">6. प्रस्तावित निर्माण वा उपयोगमा परिवर्तनको लागि
                                        मापदण्ड बमोजिम
                                        स्वीकृतिको किसिम</label>
                                    <select
                                        class="form-select @error('mapApplyDetail.change_acceptance_type') is-invalid @enderror"
                                        name="approval_type" wire:model="mapApplyDetail.change_acceptance_type"
                                        required>
                                        <option value="">छानुहोस *</option>
                                        @foreach ($acceptanceTypes as $acceptanceType)
                                            <option value="{{ $acceptanceType['value'] }}">
                                                {{ $acceptanceType['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mapApplyDetail.change_acceptance_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="form-label">7. निर्माणको लागि प्रस्तावित जग्गाको कित्ता नं.</label>
                                    <input type="text" class="form-control"
                                        value="{{ $mapApply->landDetail->lot_no }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">

                                    <label for="form-label">8. जग्गाधनी प्रमाण पुर्जा अनुसारको जग्गाको
                                        क्षेत्रफल</label>
                                    <input type="text" class="form-control"
                                        value="{{ $mapApply->landDetail->area_sqm }}" readonly>

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">9. फिल्ड नाप अनुसारको जग्गाको वास्तविक क्षेत्रफल
                                        sqm</label>
                                    <input type="number"
                                        class="form-control @error('mapApplyDetail.field_measurement_area') is-invalid @enderror"
                                        name="field_measurement_area"
                                        wire:model="mapApplyDetail.field_measurement_area"
                                        placeholder="१३. साविक अन्य निर्माण (भवन वाहेक जस्तै प्रस्वाल, टहरा, आदि) ले काटिसकेको"
                                        required>
                                    @error('mapApplyDetail.field_measurement_area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">10. प्रस्तावित भवनको प्लिन्थको क्षेत्रफल
                                        (sqm)</label>
                                    <input type="number"
                                        class="form-control @error('mapApplyDetail.building_plinth_area') is-invalid @enderror"
                                        name="building_plinth_area" wire:model="mapApplyDetail.building_plinth_area"
                                        placeholder="प्रस्तावित भवनको प्लिन्थको क्षेत्रफल(sqm)" required>
                                    @error('mapApplyDetail.building_plinth_area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Construction Details Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">11. उद्देश्य वा पूर्व भवन/निर्माण तला र क्षेत्र विवरण:</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive d-flex gap-2">
                                <table class="table table-bordered" id="constructionAreaTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>तल्ला</th>
                                            <th>उद्देश्य निर्माण क्षेत्र</th>
                                            <th>पूर्व निर्माण क्षेत्र</th>
                                            <th>कुल क्षेत्रफल</th>
                                            <th>उचाई</th>
                                            <th>कैफियत</th>
                                            <th>कार्य</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($constructionStoreyPurpose as $index => $purpose)
                                            <tr>
                                                <td>
                                                    <select
                                                        class="form-control @error('constructionStoreyPurpose.' . $index . '.storey_id') is-invalid @enderror"
                                                        name="constructionStoreyPurpose[{{ $index }}][storey_id]"
                                                        wire:model="constructionStoreyPurpose.{{ $index }}.storey_id">
                                                        <option value="">तल्ला चयन गर्नुहोस्</option>
                                                        @foreach ($storeys as $storey)
                                                            <option value="{{ $storey->id }}">
                                                                {{ $storey->title ?? 'Storey ' . $storey->id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('constructionStoreyPurpose.' . $index . '.storey_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control purposed-area @error('constructionStoreyPurpose.' . $index . '.purposed_area') is-invalid @enderror"
                                                        name="constructionStoreyPurpose[{{ $index }}][purposed_area]"
                                                        wire:model.defer="constructionStoreyPurpose.{{ $index }}.purposed_area"
                                                        wire:input.debounce.200ms="updateTotalArea({{ $index }})">
                                                    @error('constructionStoreyPurpose.' . $index . '.purposed_area')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control former-area @error('constructionStoreyPurpose.' . $index . '.former_area') is-invalid @enderror"
                                                        name="constructionStoreyPurpose[{{ $index }}][former_area]"
                                                        wire:model.defer="constructionStoreyPurpose.{{ $index }}.former_area"
                                                        wire:input.debounce.200ms="updateTotalArea({{ $index }})">
                                                    @error('constructionStoreyPurpose.' . $index . '.former_area')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number" class="form-control total-area" readonly
                                                        value="{{ $purpose['total_area'] ?? 0 }}">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('constructionStoreyPurpose.' . $index . '.height') is-invalid @enderror"
                                                        name="constructionStoreyPurpose[{{ $index }}][height]"
                                                        wire:model="constructionStoreyPurpose.{{ $index }}.height">
                                                    @error('constructionStoreyPurpose.' . $index . '.height')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="text"
                                                        class="form-control @error('constructionStoreyPurpose.' . $index . '.remarks') is-invalid @enderror"
                                                        name="constructionStoreyPurpose[{{ $index }}][remarks]"
                                                        wire:model="constructionStoreyPurpose.{{ $index }}.remarks">
                                                    @error('constructionStoreyPurpose.' . $index . '.remarks')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td class="text-end">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        wire:click="removeStoreyPurpose({{ $index }})">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr class="table-secondary">
                                            <th>कुल</th>
                                            <th>
                                                <span>{{ $totalPurposedArea }}</span>
                                            </th>
                                            <th>
                                                <span>{{ $totalFormerArea }}</span>
                                            </th>
                                            <th>
                                                <span>{{ $totalCombinedArea }}</span>
                                            </th>
                                            <th>
                                                <span>{{ $totalHeight }}</span>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                                <div>
                                    <button type="button" class="btn btn-sm btn-primary add-row"
                                        wire:click="addStoreyPurpose">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24"
                                            style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                            <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Construction Details -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">अन्य निर्माण विवरणहरू</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">12. प्रस्तावित अन्य निर्माण (भवन बाहेक जस्तै पर्खाल,
                                        टहरा, आदि)
                                        ले
                                        ढाक्ने क्षेत्रफल</label>
                                    <input type="text" wire:model="mapApplyDetail.other_construction_area"
                                        class="form-control @error('other_construction_area') is-invalid @enderror"
                                        name="other_construction_area"
                                        placeholder="१२. प्रस्तावित अन्य निर्माण (भवन वाहेक जस्तै पस्वाल, टहरा, आदि) ले ढाक्ने क्षेत्रफल*"
                                        required>
                                    @error('other_construction_area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">13. साविक अन्य निर्माण (भवन वाहेक जस्तै प्रस्वाल,
                                        टहरा, आदि) ले
                                        काटिसकेको</label>
                                    <input type="text" wire:model="mapApplyDetail.former_other_construction_area"
                                        class="form-control @error('former_other_construction_area') is-invalid @enderror"
                                        name="former_other_construction_area"
                                        placeholder="१३. साविक अन्य निर्माण (भवन वाहेक जस्तै प्रस्वाल, टहरा, आदि) ले काटिसकेको*"
                                        required>
                                    @error('former_other_construction_area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">14. निर्माणको किसिम</label>
                                    <select
                                        class="form-select @error('building_construction_type_id') is-invalid @enderror"
                                        name="building_construction_type_id"
                                        wire:model="mapApplyDetail.building_construction_type_id" required>
                                        <option value="">छानुहोस *</option>
                                        @foreach ($buildingConstructionTypes as $buildingConstructionType)
                                            <option value="{{ $buildingConstructionType->id }}">
                                                {{ $buildingConstructionType->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('building_construction_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label">15. भवनको गाह्रोमा प्रयोग सामाग्री (इँटा, ढंगा, ब्लक आदि)
                                        को विवरण</label>
                                    <input type="text"
                                        class="form-control @error('exterior_materials') is-invalid @enderror"
                                        name="exterior_materials"
                                        placeholder="भवनको गाह्रोमा प्रयोग सामाग्री (इँटा, ढंगा, ब्लक
                                        आदि) को विवरण"
                                        wire:model="mapApplyDetail.material_used">
                                    @error('exterior_materials')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">16. भवनको छानाको किसिम:</label>
                                    <select class="form-select @error('building_roof_type_id') is-invalid @enderror"
                                        name="building_roof_type_id" wire:model="mapApplyDetail.building_roof_type_id"
                                        required>
                                        <option value="">छानुहोस *</option>
                                        @foreach ($buildingRoofTypes as $buildingRoofType)
                                            <option value="{{ $buildingRoofType->id }}">
                                                {{ $buildingRoofType->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('building_roof_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Distance From Road Section -->
                    @php
                        $directions = [
                            'front' => 'अगाडि',
                            'right' => 'दायाँ',
                            'left' => 'बायाँ',
                            'back' => 'पछाडि',
                        ];
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">17. सडकदेखि प्रस्तावित भवनसम्मको दूरी</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="min-width:1200px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" rowspan="2">जग्गाको</th>
                                            <th class="align-middle" rowspan="2">
                                                सडकको चौडाइ</th>
                                            <th colspan="2">
                                                घरदेखि सडकको केन्द्रसम्मको दूरी</th>
                                            <th colspan="2">
                                                घरदेखि सडकको छेउसम्मको दूरी</th>
                                            <th colspan="2">
                                                घरदेखि बाटोको दायाँपट्टिको दूरी</th>
                                            <th colspan="2">फिर्ता सेट गर्नुहोस्</th>
                                        </tr>
                                        <tr>
                                            <th>छोडिएको</th>
                                            <th>बायाँ तिर न्यूनतम दूरी</th>
                                            <th>छोडिएको</th>
                                            <th>
                                                बायाँ तिर न्यूनतम दूरी</th>
                                            <th>छोडिएको</th>
                                            <th>
                                                बायाँ तिर न्यूनतम दूरी</th>
                                            <th>छोडिएको</th>
                                            <th>
                                                बायाँ तिर न्यूनतम दूरी</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($directions as $key => $label)
                                            <tr>
                                                {{-- Store direction as part of the wire:model --}}
                                                <td>
                                                    {{ $label }}
                                                    <input type="hidden"
                                                        wire:model.defer="roads.{{ $key }}.direction"
                                                        value="{{ $label }}">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.width') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.width">
                                                    @error('roads.' . $key . '.width')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.dist_from_middle') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.dist_from_middle">
                                                    @error('roads.' . $key . '.dist_from_middle')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.min_dist_from_middle') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.min_dist_from_middle">
                                                    @error('roads.' . $key . '.min_dist_from_middle')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.dist_from_side') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.dist_from_side">
                                                    @error('roads.' . $key . '.dist_from_side')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.min_dist_from_side') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.min_dist_from_side">
                                                    @error('roads.' . $key . '.min_dist_from_side')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.dist_from_right') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.dist_from_right">
                                                    @error('roads.' . $key . '.dist_from_right')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.min_dist_from_right') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.min_dist_from_right">
                                                    @error('roads.' . $key . '.min_dist_from_right')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.setback') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.setback">
                                                    @error('roads.' . $key . '.setback')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('roads.' . $key . '.min_setback') is-invalid @enderror"
                                                        wire:model.defer="roads.{{ $key }}.min_setback">
                                                    @error('roads.' . $key . '.min_setback')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- Distance From Outer Wall Section -->
                    @php
                        $directions = [
                            'east' => 'पूर्व',
                            'west' => 'पश्चिम',
                            'north' => 'उत्तर',
                            'south' => 'दक्षिण',
                        ];
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">18. बाहिरी पर्खालदेखि सिमानासम्मको दूरी</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>दिशा</th>
                                            <th>सडक छ</th>
                                            <th>
                                                ढोका/झ्यालहरू छन्</th>
                                            <th>
                                                बायाँ तिर न्यूनतम दूरी</th>
                                            <th>छोडिएको</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($directions as $key => $label)
                                            <tr>
                                                <td>
                                                    {{ $label }}
                                                    <input type="hidden"
                                                        wire:model.defer="distanceToWall.{{ $key }}.direction"
                                                        value="{{ $label }}">
                                                </td>
                                                <td>
                                                    <select
                                                        class="form-select @error('distanceToWall.' . $key . '.has_road') is-invalid @enderror"
                                                        wire:model.defer="distanceToWall.{{ $key }}.has_road">
                                                        <option value="">छानुहोस *</option>
                                                        <option value="1">छ</option>
                                                        <option value="0">छैन</option>
                                                    </select>
                                                    @error('distanceToWall.' . $key . '.has_road')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select
                                                        class="form-select @error('distanceToWall.' . $key . '.does_have_wall_door') is-invalid @enderror"
                                                        wire:model.defer="distanceToWall.{{ $key }}.does_have_wall_door">
                                                        <option value="">छानुहोस *</option>
                                                        <option value="1">छ</option>
                                                        <option value="0">छैन</option>
                                                    </select>
                                                    @error('distanceToWall.' . $key . '.does_have_wall_door')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('distanceToWall.' . $key . '.min_dist_left') is-invalid @enderror"
                                                        wire:model.defer="distanceToWall.{{ $key }}.min_dist_left">
                                                    @error('distanceToWall.' . $key . '.min_dist_left')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('distanceToWall.' . $key . '.dist_left') is-invalid @enderror"
                                                        wire:model.defer="distanceToWall.{{ $key }}.dist_left">
                                                    @error('distanceToWall.' . $key . '.dist_left')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- Cantilever Distance Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">19. सार्वजनिक जग्गा, नदी, क्लो आदिको किनारामा निर्माण प्रस्ताव
                                गरिएको भए सोको
                                नाम
                                तथा विवरण (नाम/विवरण)</h5>
                        </div>
                        <div class="card-body">
                            <!-- Public Property Name Input -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input type="text"
                                        class="form-control @error('mapApplyDetail.public_property_name') is-invalid @enderror"
                                        name="public_property_name" wire:model="mapApplyDetail.public_property_name"
                                        placeholder="सार्वजनिक जग्गा, नदी, क्लो आदिको किनारामा निर्माण प्रस्ताव गरिएको भए सोको नाम तथा विवरण (नाम/विवरण)*"
                                        required>
                                    @error('mapApplyDetail.public_property_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Distance Left Input -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">छोड्नु पर्ने न्यूनतम दूरी (meters/feet)</label>
                                    <input type="number"
                                        class="form-control @error('mapApplyDetail.distance_left') is-invalid @enderror"
                                        name="distance_left" wire:model="mapApplyDetail.distance_left"
                                        placeholder="Minimum distance to be dropped (meters/feet)*" required>
                                    @error('mapApplyDetail.distance_left')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $cantileverDirections = [
                            'front' => 'अगाडि',
                            'right' => 'दायाँ',
                            'left' => 'बायाँ',
                            'back' => 'पछाडि',
                        ];
                    @endphp

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">20. Cantilever दूरी</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>दिशा</th>
                                            <th>उद्देश्य दूरी</th>
                                            <th>
                                                स्वीकृत गर्न सकिने न्यूनतम दूरी</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cantileverDirections as $key => $label)
                                            <tr>
                                                <td>
                                                    {{ $label }}
                                                    <input type="hidden"
                                                        wire:model.defer="cantileverDetails.{{ $key }}.direction"
                                                        value="{{ $label }}">
                                                    @error('cantileverDetails.' . $key . '.direction')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        wire:model.defer="cantileverDetails.{{ $key }}.distance">
                                                    @error('cantileverDetails.' . $key . '.distance')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        wire:model.defer="cantileverDetails.{{ $key }}.minimum">
                                                    @error('cantileverDetails.' . $key . '.minimum')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- High Tension Line Detail -->
                    @php
                        $tensionDirections = [
                            'front' => 'अगाडि',
                            'right' => 'दायाँ',
                            'left' => 'बायाँ',
                            'back' => 'पछाडि',
                        ];
                    @endphp

                    <!-- High Tension Line Detail -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">21. उच्च तनाव रेखा विवरण</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>दिशा</th>
                                            <th>उद्देश्य दूरी</th>
                                            <th>
                                                स्वीकृत गर्न सकिने न्यूनतम दूरी</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tensionDirections as $key => $label)
                                            <tr>
                                                <td>
                                                    {{ $label }}
                                                    <input type="hidden"
                                                        wire:model.defer="highTensionDetails.{{ $key }}.direction"
                                                        value="{{ $label }}">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('highTensionDetails.' . $key . '.distance') is-invalid @enderror"
                                                        wire:model.defer="highTensionDetails.{{ $key }}.distance">
                                                    @error('highTensionDetails.' . $key . '.distance')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        class="form-control @error('highTensionDetails.' . $key . '.minimum') is-invalid @enderror"
                                                        wire:model.defer="highTensionDetails.{{ $key }}.minimum">
                                                    @error('highTensionDetails.' . $key . '.minimum')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Declaration Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">घोषणा</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="border p-3 mb-3 rounded bg-light">
                                        <h6 class="fw-bold text-dark">नक्सा बनाउनेको तर्फबाट</h6>
                                        <p class="text-dark">मैले नक्सा बनाउने प्राविधिकले गर्नुपर्ने कुराहरुको
                                            अध्ययन गर्न
                                            दरखास्तवाला श्री {{ $mapApply->full_name }} को नक्सा बनाएको हुँ ।
                                            उक्त नक्सा तोकिएको मापदण्ड विपरित बनाइएको ठहरे नियमानुसार सहुँला
                                            बुझाउँला ।</p>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">सही :
                                                ..............................</label>
                                        </div>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">नाम, थर :
                                                .................................</label>
                                        </div>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">योग्यता एवं पद :
                                                .................................</label>
                                        </div>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">कन्सल्टीङ फर्मको नाम :
                                                .................................</label>
                                        </div>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">उप-महान.पा.मा दर्ता भएका
                                                व्यवसाय
                                                प्रमाण-पत्रको नं. .................................</label>
                                        </div>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">फर्मको छाप :
                                                .................................</label>
                                        </div>
                                        <div class="mb-1 ">
                                            <label class="form-label fw-medium text-dark">मिति :
                                                {{ replaceNumbers(ne_date(date('Y-m-d'), 'MM,dd, yyyy | l'), toNepali: true) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 mb-3 rounded bg-light">
                                        <h6 class="text-dark fw-bold">नक्सा पास एवं निर्माण इजाजतको लागि दरखास्त
                                            गर्नेको
                                            तर्फबाट
                                        </h6>
                                        <p class="text-dark">नक्सा पास एवं निर्माण इजाजतको लागि दरखास्त गर्नेको
                                            तर्फबाट माथि
                                            उल्लिखित
                                            प्राविधिक विवरण एवं उप-महानगरपालिकाको मापदण्ड बमोजिम नक्सा अनुसार
                                            निर्माण
                                            कार्य गर्न म/ हामी मञ्जुर छु/छौँ । मापदण्ड विपरित र ठीक विपरित गर्दा
                                            कानुन
                                            बमोजिम सहुँला बुझाउँला।</p>
                                        <div class="mb-1">
                                            <label class="form-label">सही :
                                                .................................</label>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">नाम, थर :
                                                {{ $mapApply->full_name }}</label>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">मिति :
                                                {{ replaceNumbers(ne_date(date('Y-m-d'), 'MM,dd, yyyy | l'), toNepali: true) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            @else
                <div class="a4-container">
                    {!! $currentEditingTemplate !!}
                </div>
            @endif
        </div>
        {!! $formStyles !!}

    </div>


    <style>
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: relative;
        }
    </style>




</div>
