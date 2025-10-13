<form wire:submit.prevent="save">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <h5 class="text-primary mb-3">{{ __('yojana::yojana.plan_details') }}</h5>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='agreement_date' class='form-label'>{{ __('yojana::yojana.agreement_date') }}</label>
                        <input wire:model='agreement_date' name='agreement_date' type='text' class='form-control'
                            readonly>
                        <div>
                            @error('evaluation.agreement_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='agreed_completion_date'
                            class='form-label'>{{ __('yojana::yojana.agreed_completion_date') }}</label>
                        <input wire:model='agreed_completion_date' name='agreed_completion_date' type='text'
                            class='form-control nepali-date'
                            placeholder="{{ __('yojana::yojana.enter_evaluation_date') }}" readonly>
                        <div>
                            @error('evaluation.agreed_completion_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='evaluation_date'
                            class='form-label'>{{ __('yojana::yojana.evaluation_date') }} <span class="text-danger">*</span></label>
                        <input wire:model='evaluation.evaluation_date' name='evaluation_date' type='text'
                            class='form-control nepali-date {{ $errors->has('evaluation.evaluation_date') ? 'is-invalid' : '' }}' id="evaluation_date"
                            placeholder="{{ __('yojana::yojana.enter_evaluation_date') }}">
                        <div>
                            @error('evaluation.evaluation_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='completion_date'
                            class='form-label'>{{ __('yojana::yojana.completion_date') }} <span class="text-danger">*</span></label>
                        <input wire:model='evaluation.completion_date' id="evaluation_completion_date"
                            name='completion_date' type='text' class='form-control nepali-date {{ $errors->has('evaluation.completion_date') ? 'is-invalid' : '' }}'
                            placeholder="{{ __('yojana::yojana.enter_completion_date') }}">
                        <div>
                            @error('evaluation.completion_date')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="text-primary mb-3">{{ __('yojana::yojana.project_implementation_method') }}</h5>
            <div class="row">
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='implementationMethod'
                            class='form-label'>{{ __('yojana::yojana.implementation_method') }}</label>
                        <input wire:model='implementationMethod' name='implementationMethod' type='text'
                            class='form-control' placeholder="{{ __('yojana::yojana.enter_implementation_method') }}"
                            readonly>
                        <div>
                            @error('evaluation.implementationMethod')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='purpose' class='form-label'>{{ __('yojana::yojana.purpose') }}</label>
                        <input wire:model='purpose' name='purpose' type='text' class='form-control'
                            placeholder="{{ __('yojana::yojana.enter_purpose') }}" readonly>
                        <div>
                            @error('evaluation.purpose')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6 mb-3'>
                    <div class='form-group'>
                        <label for='area' class='form-label'>{{ __('yojana::yojana.area') }}</label>
                        <input wire:model='area' name='area' type='text' class='form-control'
                            placeholder="{{ __('yojana::yojana.enter_evaluation_date') }}" readonly>
                        <div>
                            @error('evaluation.area')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-primary mt-3 ps-2">{{ __('yojana::yojana.cost_details') }}</h4>

    <div class="card mt-3">

        <div class="card-body">
            <h5 class="text-primary">{{ __('yojana::yojana.activity_details') }}</h5>
            <div style="overflow-x:auto;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('yojana::yojana.sno') }}</th>
                            <th>{{ __('yojana::yojana.activity') }}</th>
                            <th>{{ __('yojana::yojana.unit') }}</th>
                            <th>{{ __('yojana::yojana.agreement') }}</th>
                            <th>{{ __('yojana::yojana.before_this') }}</th>
                            <th>{{ __('yojana::yojana.up_to_date') }}</th>
                            <th>{{ __('yojana::yojana.current') }}</th>
                            <th>{{ __('yojana::yojana.rate') }}</th>
                            <th class="text-nowrap">{{ __('yojana::yojana.amount') }} <span class="text-danger">*</span></th>
                            <th>{{ __('yojana::yojana.vat') }}</th>
                            <th>{{ __('yojana::yojana.vat_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costEstimationData as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail['activity_id'] ?? '-' }}</td>
                                <td>{{ $detail['unit'] ?? '-' }}</td>
                                <td>{{ replaceNumbersWithLocale($detail['agreement'] ?? '-', true) }}</td>
                                <td><input type="text" class="form-control"
                                        wire:model="costEstimationData.{{ $index }}.before_this" readonly></td>
                                <td><input type="number" class="form-control {{ $errors->has('costEstimationData.'.$index.'.up_to_date_amount') ? 'is-invalid' : '' }}"
                                        wire:model="costEstimationData.{{ $index }}.up_to_date_amount"
                                        wire:input="calculateAmount({{ $index }})">
                                    @error('costEstimationData.'.$index.'.up_to_date_amount')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>{{ floatval($costEstimationData[$index]['up_to_date_amount'] ?? 0) }}</td>
                                <td>{{ $detail['rate'] }}</td>
                                <td>
                                    <input type="number" step="0.01" class="form-control {{ $errors->has('costEstimationData.'.$index.'.assessment_amount') ? 'is-invalid' : '' }}"
                                           wire:model="costEstimationData.{{ $index }}.assessment_amount"
                                           wire:input="calculateAmount({{ $index }})">
                                    @error('costEstimationData.'.$index.'.assessment_amount')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input"
                                        wire:model="costEstimationData.{{ $index }}.is_vatable"
                                        wire:change="vatToggled({{ $index }})">
                                </td>
                                <td>
                                    {{ number_format($costEstimationData[$index]['vat_amount'] ?? 0, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="8" class="text-end">{{ __('yojana::yojana.total') }}</th>
                            <th>{{ number_format($this->totalAssessment, 2) }}</th>
                            <th></th>
                            <th>{{ number_format($this->totalVat, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="text-primary">{{ __('yojana::yojana.budget_details') }}</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('yojana::yojana.estimated_cost') }}</th>
                        <th>{{ __('yojana::yojana.total_payment_amount') }}</th>
                        <th>{{ __('yojana::yojana.remaining_amount') }}</th>
                        <th class="text-nowrap">{{ __('yojana::yojana.installment_no') }} <span class="text-danger">*</span></th>
                        <th>{{ __('yojana::yojana.evaluation_amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" readonly wire:model="costTotal"></td>
                        <td><input type="text" class="form-control" readonly wire:model="advancePayment"></td>
                        <td><input type="text" class="form-control" readonly
                                value="{{ $costTotal - $advancePayment }}"></td>
                        <td><select name="" id="" wire:model='evaluation.installment_no'
                                class="form-select {{ $errors->has('evaluation.installment_no') ? 'is-invalid' : '' }}">
                                <option value="">{{ __('yojana::yojana.select_an_option') }}</option>
                                @foreach ($installments as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('evaluation.installment_no')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </td>
                        <td><input type="text" name="evaluation_amount" class="form-control"
                                wire:model="evaluation.evaluation_amount" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="mb-5 text-primary">{{ __('yojana::yojana.implementation_and_public_testing_details') }}</h5>

            <div class="form-group row mb-3">
                <label for="implementation_status"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('1. ',true). __('yojana::yojana.whether_or_not_the_action_plan_has_been_implemented') }}</label>

                <div class="col-sm-3 d-flex align-items-center">
                    <input type="checkbox" wire:model='evaluation.is_implemented' name='is_implemented'
                        class="form-check-input" style="transform: scale(1.3); border:1px solid black;">

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="financial_status"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('2. ',true). __('yojana::yojana.financial_status') }}</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="checkbox" wire:model='evaluation.is_budget_utilized' name='is_budget_utilized'
                        class="form-check-input" style="transform: scale(1.3); border:1px solid black;">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="quality_status"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('3. ',true). __('yojana::yojana.quality_whether_the_work_was_done_to_maintain_the_specified_quality') }}</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="checkbox" wire:model='evaluation.is_quality_maintained' name='is_quality_maintained'
                        class="form-check-input" style="transform: scale(1.3); border:1px solid black;">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="target_group_reached"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('4. ',true). __('yojana::yojana.whether_the_program_has_reached_the_specified_target_group_whether_they_have_participated_or_not') }}</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="checkbox" wire:model='evaluation.is_reached' name='is_reached'
                        class="form-check-input" style="transform: scale(1.3); border:1px solid black;">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="public_audit_done"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('5. ',true). __('yojana::yojana.public_testingnot_conducted') }}</label>
                <div class="col-sm-3 d-flex align-items-center">
                    <input type="checkbox" wire:model='evaluation.is_tested' name='is_tested'
                        class="form-check-input" style="transform: scale(1.3); border:1px solid black;">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="public_audit_date"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('6. ',true). __('yojana::yojana.public_testing_date') }}</label>
                <div class="col-sm-3">
                    <input type="text" wire:model='evaluation.testing_date' name='testing_date'
                        class="form-control nepali-date {{ $errors->has('evaluation.testing_date') ? 'is-invalid' : '' }}" id="testing_date">
                    @error('evaluation.testing_date')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="attendance_count"
                    class="col-sm-9 fw-semibold fs-6">{{replaceNumbersWithLocale('7. ',true). __('yojana::yojana.attendance_count') }}</label>
                <div class="col-sm-3">
                    <input type="number" wire:model="evaluation.attendance_number" name="attendance_number"
                        class="form-control {{ $errors->has('evaluation.attendance_number') ? 'is-invalid' : '' }}">
                    @error('evaluation.attendance_number')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="text-primary">{{ __('yojana::yojana.documents') }}</h5>

            <div class='col-md-6 mb-1'>
                <div class='form-group'>
                    <label for='ward_recommendation_document'
                        class='form-label'>{{ __('yojana::yojana.ward_recommendation_document') }}</label>
                    <input wire:model='wardRecommendationDocument' name='ward_recommendation_document' type='file'
                        class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_ward_recommendation_document') }}">
                    <div wire:loading wire:target="wardRecommendationDocument">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($wardRecommendationDocumentUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1">
                                <strong>{{ __('yojana::yojana.ward_recommendation_document_preview') }}:</strong>
                            </p>
                            <a href="{{ $wardRecommendationDocumentUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('evaluation.ward_recommendation_document')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-1'>
                <div class='form-group'>
                    <label for='technical_evaluation_document'
                        class='form-label'>{{ __('yojana::yojana.technical_evaluation_document') }}</label>
                    <input wire:model='technicalEvaluationDocument' name='technical_evaluation_document'
                        type='file' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_technical_evaluation_document') }}">
                    <div>
                        @error('evaluation.technical_evaluation_document')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                    <div wire:loading wire:target="technicalEvaluationDocument">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($technicalEvaluationDocumentUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1">
                                <strong>{{ __('yojana::yojana.ward_recommendation_document_preview') }}:</strong>
                            </p>
                            <a href="{{ $technicalEvaluationDocumentUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Committee Report -->
            <div class="col-md-6 mb-1">
                <div class="form-group">
                    <label for="committee_report"
                        class="form-label">{{ __('yojana::yojana.committee_report') }}</label>
                    <input wire:model="committeeReport" name="committee_report" type="file" class="form-control"
                        placeholder="{{ __('yojana::yojana.enter_committee_report') }}">
                    <div wire:loading wire:target="committeeReport">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($committeeReportUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1"><strong>{{ __('yojana::yojana.committee_report_preview') }}:</strong>
                            </p>
                            <a href="{{ $committeeReportUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('committeeReport')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Attendance Report -->
            <div class="col-md-6 mb-1">
                <div class="form-group">
                    <label for="attendance_report"
                        class="form-label">{{ __('yojana::yojana.attendance_report') }}</label>
                    <input wire:model="attendanceReport" name="attendance_report" type="file"
                        class="form-control" placeholder="{{ __('yojana::yojana.enter_attendance_report') }}">
                    <div wire:loading wire:target="attendanceReport">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($attendanceReportUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1"><strong>{{ __('yojana::yojana.attendance_report_preview') }}:</strong>
                            </p>
                            <a href="{{ $attendanceReportUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('attendanceReport')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Construction Progress Photo -->
            <div class="col-md-6 mb-1">
                <div class="form-group">
                    <label for="construction_progress_photo"
                        class="form-label">{{ __('yojana::yojana.construction_progress_photo') }}</label>
                    <input wire:model="constructionProgressPhoto" name="construction_progress_photo" type="file"
                        class="form-control"
                        placeholder="{{ __('yojana::yojana.enter_construction_progress_photo') }}">
                    <div wire:loading wire:target="constructionProgressPhoto">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($constructionProgressPhotoUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1">
                                <strong>{{ __('yojana::yojana.construction_progress_photo_preview') }}:</strong>
                            </p>
                            <a href="{{ $constructionProgressPhotoUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('constructionProgressPhoto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Work Completion Report -->
            <div class="col-md-6 mb-1">
                <div class="form-group">
                    <label for="work_completion_report"
                        class="form-label">{{ __('yojana::yojana.work_completion_report') }}</label>
                    <input wire:model="workCompletionReport" name="work_completion_report" type="file"
                        class="form-control" placeholder="{{ __('yojana::yojana.enter_work_completion_report') }}">
                    <div wire:loading wire:target="workCompletionReport">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($workCompletionReportUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1">
                                <strong>{{ __('yojana::yojana.work_completion_report_preview') }}:</strong>
                            </p>
                            <a href="{{ $workCompletionReportUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('workCompletionReport')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Expense Report -->
            <div class="col-md-6 mb-1">
                <div class="form-group">
                    <label for="expense_report" class="form-label">{{ __('yojana::yojana.expense_report') }}</label>
                    <input wire:model="expenseReport" name="expense_report" type="file" class="form-control"
                        placeholder="{{ __('yojana::yojana.enter_expense_report') }}">
                    <div wire:loading wire:target="expenseReport">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($expenseReportUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1"><strong>{{ __('yojana::yojana.expense_report_preview') }}:</strong></p>
                            <a href="{{ $expenseReportUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('expenseReport')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Other Document -->
            <div class="col-md-6 mb-1">
                <div class="form-group">
                    <label for="other_document" class="form-label">{{ __('yojana::yojana.other_document') }}</label>
                    <input wire:model="otherDocument" name="other_document" type="file" class="form-control"
                        placeholder="{{ __('yojana::yojana.enter_other_document') }}">
                    <div wire:loading wire:target="otherDocument">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($otherDocumentUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1"><strong>{{ __('yojana::yojana.other_document_preview') }}:</strong></p>
                            <a href="{{ $otherDocumentUrl }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('otherDocument')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="mb-3 text-primary">{{ __('yojana::yojana.plan_status') }}</h5>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='evaluation_no' class='form-label'>{{ __('yojana::yojana.evaluation_no') }}</label>
                    <input wire:model='evaluation.evaluation_no' name='evaluation_no' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_evaluation_no') }}">
                    <div>
                        @error('evaluation.evaluation_no')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
    </div>
</form>
