<div>
    <form wire:submit.prevent="save">
        {{--    <div class="card-body" wire:loading.class="invisible"> --}}
        <div class="card-body d-flex justify-content-between">
            <a class="btn btn-info" type="button" wire:click="costEstimationPrint" target="_blank">
               <i class="bx bx-printer"></i> {{ __('yojana::yojana.print') }}
            </a>
            @if($showApprovalLetter)
                <button type="button" class="btn btn-info" wire:click="printApprovalLetter" >
                   <i class="bx bx-envelope"></i> {{ __('yojana::yojana.approval_letter') }}
                </button>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class='col-md-5 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='activity_group_id'>{{ __('yojana::yojana.activity_group') }}</label>
                            <select wire:model='costEstimationDetail.activity_group_id' name='activity_group_id'
                                type='text'
                                class='form-control {{ $errors->has('costEstimationDetail.activity_group_id') ? 'is-invalid' : '' }}'>
                                <option value="" hidden>{{ __('yojana::yojana.select_activity_group') }}</option>
                                @foreach ($activityGroups as $id => $title)
                                    <option value="{{ $id }}">{{ $title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('costEstimationDetail.activity_group_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-5 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='activity_id'>{{ __('yojana::yojana.activity') }}</label>
                            <select wire:model='costEstimationDetail.activity_id' wire:change="loadUnit($event.target.value)" name='activity_id' type='text'
                                class='form-control {{ $errors->has('costEstimationDetail.activity_id') ? 'is-invalid' : '' }}'>
                                <option value="" hidden>{{ __('yojana::yojana.select_activity') }}</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->title }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('costEstimationDetail.activity_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-2 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='unit'>{{ __('yojana::yojana.unit') }}</label>
                            <input disabled name='unit' type='text' value="{{$units[$costEstimationDetail->unit] ?? ''}}"
                                class="form-control {{ $errors->has('costEstimationDetail.unit') ? 'is-invalid' : '' }}">
                            <div>
                                @error('costEstimationDetail.unit')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-2 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='quantity'>{{ __('yojana::yojana.quantity') }}</label>
                            <input wire:model='costEstimationDetail.quantity' name='quantity' type='number'
                                wire:input.debounce.300ms="recalculateVat"
                                class='form-control {{ $errors->has('costEstimationDetail.quantity') ? 'is-invalid' : '' }}'
                                placeholder='{{ __('yojana::yojana.enter_quantity') }}'>
                            <div>
                                @error('costEstimationDetail.quantity')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='col-md-2 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='rate'>{{ __('yojana::yojana.rate') }}</label>
                            <input wire:model='costEstimationDetail.rate' name='rate' type='number'
                                wire:input.debounce.300ms="recalculateVat"
                                class='form-control {{ $errors->has('costEstimationDetail.rate') ? 'is-invalid' : '' }}'
                                placeholder='{{ __('yojana::yojana.enter_rate') }}'>
                            <div>
                                @error('costEstimationDetail.rate')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='col-md-2 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='amount'>{{ __('yojana::yojana.amount') }} <span class="text-danger">*</span></label>
                            <input wire:model='costEstimationDetail.amount' name='amount' type='number'
                                class='form-control {{ $errors->has('costEstimationDetail.amount') ? 'is-invalid' : '' }}'
                                placeholder='{{ __('yojana::yojana.enter_amount') }}'>
                            <div>
                                @error('costEstimationDetail.amount')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='col-md-2 mb-3'>
                        <div class='form-group'>
                            <label class="form-label" for='is_vatable'>{{ __('yojana::yojana.is_it_vatable') }}</label><br>
                            <input wire:model="is_vatable" name="is_vatable" type="checkbox"
                                class="form-check-input ms-4 mt-1" id="is_vatable" wire:click="toggleField">
                            <div>
                                @error('is_vatable')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='col-md-2'>
                        <div class='form-group'>
                            <label class="form-label" for='vat_amount'>{{ __('yojana::yojana.vat_amount') }}</label>
                            <input wire:model='costEstimationDetail.vat_amount' name='vat_amount' type='number'
                                class='form-control {{ $errors->has('costEstimationDetail.vat_amount') ? 'is-invalid' : '' }}'
                                {{ !$is_vatable ? 'disabled' : '' }}>
                            <div>
                                @error('costEstimationDetail.vat_amount')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='col-md-2 mt-4 mb-3 center'>
                        @if ($editingIndex !== null)
                            <p wire:click="addDetails" class="btn btn-info ms-4 mt-1">{{ __('yojana::yojana.update') }}</p>
                        @else
                            <p wire:click="addDetails" class="btn btn-info ms-2 mt-1">{{ __('yojana::yojana.add_record') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="text-primary">{{ __('yojana::yojana.added_records') }}</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('yojana::yojana.sno') }}</th>
                                <th>{{ __('yojana::yojana.activity') }}</th>
                                <th>{{ __('yojana::yojana.unit') }}</th>
                                <th>{{ __('yojana::yojana.quantity') }}</th>
                                <th>{{ __('yojana::yojana.rate') }}</th>
                                <th>{{ __('yojana::yojana.amount') }}</th>
                                <th>{{ __('yojana::yojana.vat_amount') }}</th>
                                <th>{{ __('yojana::yojana.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($records))
                                <tr>
                                    <td colspan="8" class="text-muted text-center">
                                        {{ __('yojana::yojana.no_records_to_show') }}
                                    </td>
                                </tr>
                            @endif
                            @foreach ($records as $index => $record)
                                <tr>
                                    <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                                    <td>{{ ($activities->firstWhere('id',$record['activity_id']))?->title ?? '-' }}</td>
                                    <td>{{ $units[$record['unit']] ?? '-' }}</td>
                                    <td>{{ replaceNumbersWithLocale($record['quantity'] ?? '-', true) }}</td>
                                    <td>{{ replaceNumbersWithLocale($record['rate'] ?? '-', true) }}</td>
                                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($record['amount'] ?? 0), true) }}</td>
                                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($record['vat_amount'] ?? 0), true) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info"
                                            wire:click="editDetails('{{ $index }}')">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="removeDetails('{{ $index }}')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>

                        @if ($records)
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>{{ __('yojana::yojana.total') }}</strong></td>
                                    <td><strong>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($total_amount ?? 0), true) }}</strong></td>
                                    <td><strong>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($total_vat_amount ?? 0), true) }}</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        <strong>{{ __('yojana::yojana.total_amount_with_vat') }}</strong>
                                    </td>
                                    <td colspan="1"><strong>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($totalWithVat ?? 0), true) }}</strong></td>
                                    <td></td>

                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{--    Configurations --}}
        <div class="card mt-4">
            <div class="card-header d-flex d-flex justify-content-between">
                <h5 class="text-primary">{{ __('yojana::yojana.added_configurations') }}</h5>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal2">
                    <i class="bx bx-cog"></i> {{ __('yojana::yojana.add_configuration') }}
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('yojana::yojana.sno') }}</th>
                                <th>{{ __('yojana::yojana.configuration') }}</th>
                                <th>{{ __('yojana::yojana.operation') }}</th>
                                <th>{{ __('yojana::yojana.rate') }}</th>
                                <th>{{ __('yojana::yojana.amount') }}</th>
                                <th>{{ __('yojana::yojana.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($configRecords))
                                <tr>
                                    <td colspan="8" class="text-muted text-center">
                                        {{ __('yojana::yojana.no_configurations_added') }}
                                    </td>
                                </tr>
                            @endif

                            @foreach ($configRecords as $index => $configRecord)
                                <tr class="">
                                    <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                                    <td>{{ $configurations[$configRecord['configuration']] ?? '-'}}</td>
                                    <td>{{ ($configRecord['operation_type'] == 'add' ? __('yojana::yojana.added') : __('yojana::yojana.deducted ')) }}</td>
                                    <td>{{ replaceNumbersWithLocale($configRecord['rate'] ?? '-', true).' %' }}</td>
                                    <td>{{ ($configRecord['operation_type'] == 'add' ? ' + ' : ' - ') . __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($configRecord['amount'] ?? 0), true) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="removeConfigRecord('{{ $index }}')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        @if ($configRecords || true)
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <strong>{{ __('yojana::yojana.total_amount_after_configuration') }}:</strong>
                                    </td>
                                    <td colspan="auto"><strong>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($totalWithConfig ?? 0), true) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <strong>{{ __('yojana::yojana.total_estimated_amount') }}:</strong>
                                    </td>
                                    <td colspan="auto"><strong>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($totalEstimatedAmount ?? 0), true) }}</strong></td>

                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{--    project costs --}}
        <div class="card mt-4">
            <form wire:submit.prevent="save">
                <div class="card-header">
                    <h5 class="text-primary">{{ __('yojana::yojana.project_cost_details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class='col-md-5'>
                            <div class='form-group'>
                                <label class="form-label" for='cost_source'>{{ __('yojana::yojana.cost_source') }}</label>
                                <select wire:model='cost_source' name='cost_source' type='text'
                                    class='form-control {{ $errors->has('cost_source') ? 'is-invalid' : '' }}'>
                                    <option value="" hidden>{{ __('yojana::yojana.select_cost_source') }}</option>
                                    @foreach ($sourceTypes as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('cost_source')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class='col-md-2'>
                            <div class='form-group'>
                                <label class="form-label" for='cost_amount'>{{ __('yojana::yojana.amount') }}</label>
                                <input wire:model='cost_amount' name='cost_amount' type='number'
                                    class='form-control {{ $errors->has('cost_amount') ? 'is-invalid' : '' }}'
                                    placeholder='{{ __('yojana::yojana.enter_amount') }}'>
                                <div>
                                    @error('cost_amount')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class='col-md-2 mt-4 center'>
                            <p wire:click="addCostRecord" class="btn btn-info ms-2 mt-1">{{ __('yojana::yojana.add') }}</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{ __('yojana::yojana.sno') }}</th>
                                <th>{{ __('yojana::yojana.source_of_cost') }}</th>
                                <th>{{ __('yojana::yojana.amount') }}</th>
                                <th>{{ __('yojana::yojana.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (empty($costRecords))
                                <tr>
                                    <td colspan="8" class="text-muted text-center">
                                        {{ __('yojana::yojana.no_records_to_show') }}
                                    </td>
                                </tr>
                            @endif

                            @foreach ($costRecords as $index => $costRecord)
                                <tr>
                                    <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                                    <td>{{ $sourceTypes[$costRecord['cost_source']] }}</td>
                                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($costRecord['cost_amount'] ?? 0), true) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                wire:click="removeCostRecord('{{ $index }}')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>{{ __('yojana::yojana.total_cost_amount') }}:</strong>
                                </td>
                                <td colspan="auto"><strong>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($this->total_cost ?? 0), true) }}</strong></td>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>

        <!-- Documents Upload-->
        <div class="card p-2 mt-4">

            <div class="card-header">
                <h5 class="text-primary">{{ __('yojana::yojana.documents') }}</h5>
            </div>

            <div class="card-body">
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='rate_analysis_document'
                            class='form-label'>{{ __('yojana::yojana.rate_analysis_document') }}</label>
                        <input wire:model='rate_analysis_document' name='rate_analysis_document' type='file'
                            class='form-control'>
                        <div>
                            @error('rate_analysis_document')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div wire:loading wire:target="rate_analysis_document">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{__('yojana::yojana.uploading')}}...
                        </div>
                        @if ($rate_analysis_document_url)
                            <div class="col-12 mb-3">
                                <p class="mb-1"><strong>{{ __('yojana::yojana.rate_analysis_document_preview') }}:</strong></p>
                                <a href="{{ $rate_analysis_document_url }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='cost_estimation_document'
                            class='form-label'>{{ __('yojana::yojana.cost_estimation_document') }}</label>
                        <input wire:model='cost_estimation_document' name='cost_estimation_document' type='file'
                            class='form-control'>
                        <div>
                            @error('cost_estimation_document')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div wire:loading wire:target="cost_estimation_document">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{__('yojana::yojana.uploading')}}...
                        </div>
                        @if ($cost_estimation_document_url)
                            <div class="col-12 mb-3">
                                <p class="mb-1"><strong>{{ __('yojana::yojana.cost_estimation_document_preview') }}:</strong></p>
                                <a href="{{ $cost_estimation_document_url }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='initial_photo'
                            class='form-label'>{{ __('yojana::yojana.photo_before_the_project_started') }}</label>
                        <input wire:model='initial_photo' name='initial_photo' type='file' class='form-control'>
                        <div>
                            @error('initial_photo')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div wire:loading wire:target="initial_photo">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{__('yojana::yojana.uploading')}}...
                        </div>
                        @if ($initial_photo_url)
                            <div class="col-12 mb-3">
                                <p class="mb-1"><strong>{{ __('yojana::yojana.photo_before_project_start_preview') }}:</strong>
                                </p>
                                <a href="{{ $initial_photo_url }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <label class="form-label d-block">{{ __('yojana::yojana.is_revised') }}</label>
                        <input type="checkbox" wire:model="is_revised" name="is_revised"
                            class="form-check-input mt-2" wire:click="toggleIsRevised">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">{{ __('yojana::yojana.revision_no') }}</label>
                        <input type="text" wire:model="revision_no" name="revision_no" class="form-control"
                            {{ !$is_revised ? 'disabled' : '' }}>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">{{ __('yojana::yojana.revision_date') }}</label>
                        <input type="date" wire:model="revision_date" name="revision_date" class="form-control"
                            value="{{ old('revision_date', date('Y-m-d')) }}" {{ !$is_revised ? 'disabled' : '' }}>
                    </div>

                    <div class="col-md-2 text-end mt-4">
                        <button type="button" wire:click="save"
                            class="btn btn-primary">{{ __('yojana::yojana.save') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    {{-- modal form --}}
    <div class="modal fade" id="indexModal2" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="ModalLabel">
                        {{ __('yojana::yojana.add_configuration') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:yojana.cost_estimation_configuration_form :$plan />
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            $('#indexModal2').modal('hide');
            $('.modal-backdrop').remove();
        });

        $('#indexModal, #indexModal2').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open').css({
                'overflow': '',
                'padding-right': ''
            });
        });


    });
    document.addEventListener('livewire:init', () => {
        Livewire.on('open-pdf-in-new-tab', (event) => {
            console.log(event);
            window.open(event.url, '_blank');
        });

    });


document.addEventListener('livewire:init', () => {
    Livewire.on('print-cost-estimation', ({ html }) => {
        printHtml(html);
    });
});

async function printHtml(html) {
    const { jsPDF } = window.jspdf;

    // Create a temporary container for the HTML string
    const container = document.createElement('div');
    container.style.width = "210mm";
    container.style.minHeight = "297mm";
    container.style.padding = "7mm 20mm";
    container.style.margin = "auto";
    container.style.background = "white";
    container.style.boxShadow = "0px 0px 5px rgba(0, 0, 0, 0.2)";
    container.style.textAlign = "left";
    container.style.position = "absolute";
    container.style.left = "-9999px"; // hide offscreen
    
    container.innerHTML = html;
    document.body.appendChild(container);

    const canvas = await html2canvas(container, {
        scale: 2,
        useCORS: true
    });

    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF('p', 'mm', 'a4');

    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = pdf.internal.pageSize.getHeight();

    const imgProps = pdf.getImageProperties(imgData);
    const imgHeight = (imgProps.height * pdfWidth) / imgProps.width;

    let heightLeft = imgHeight;
    let position = 0;

    pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
    heightLeft -= pdfHeight;

    while (heightLeft > 1) {
        position -= pdfHeight;
        pdf.addPage();
        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
        heightLeft -= pdfHeight;
    }

    pdf.autoPrint();
    window.open(pdf.output('bloburl'), '_blank');

    // Clean up the container
    document.body.removeChild(container);
}


</script>
@endpush
