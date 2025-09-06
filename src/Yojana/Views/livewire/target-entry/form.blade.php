<div>
<form wire:submit.prevent="save">

        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label">{{ __('yojana::yojana.progress_indicator') }}</label>
                <select wire:model.lazy="targetEntry.progress_indicator_id" 
                class="form-select @error('targetEntry.progress_indicator_id') is-invalid @enderror"
                style="width: 300px;">

                    <option value="" hidden>-- {{__('yojana::yojana.select_progress_indicator')}} -- </option>
                    @foreach ($progressIndicators as $id => $title)
                        <option value="{{ $id }}">{{ $title }}</option>
                    @endforeach
                </select>
                @error('targetEntry.progress_indicator_id')
                    <small class='text-danger'>{{ $message }}</small>
                @enderror
                <button class="btn btn-secondary" type="button" data-bs-toggle="modal"
                        data-bs-target="#processIndicatorModal" onclick="resetForm()">
                    <i class="bx bx-plus"></i>{{ __('yojana::yojana.add_progress_indicator') }}
                </button>
            </div>
            <div>

            </div>
        </div>

    <!-- Table layout for progress tracking -->
    <div class="table-responsive">
        <table class="table table-bordered custom-border">
            <thead>
            <tr>
                <th class="text-center align-middle" rowspan="2">{{ __('yojana::yojana.progress_type') }}</th>
                <th class="text-center align-middle" rowspan="2">{{ __('yojana::yojana.total_progress') }}</th>
                <th class="text-center align-middle" rowspan="2">{{ __('yojana::yojana.last_year_progress') }}</th>
                <th class="text-center" colspan="4">{{ __('yojana::yojana.current_year_progress') }}</th>
            </tr>
            <tr>
                <th class="text-center">{{ __('yojana::yojana.total_goals') }}</th>
                <th class="text-center">{{ __('yojana::yojana.first_quarter') }}</th>
                <th class="text-center">{{ __('yojana::yojana.second_quarter') }}</th>
                <th class="text-center">{{ __('yojana::yojana.third_quarter') }}</th>
            </tr>
            </thead>
            <tbody>
            <!-- Physical progress row -->
            <tr>
                <td class="fw-medium">{{ __('yojana::yojana.physical') }}</td>

                <td>
                    <input wire:model.lazy="targetEntry.total_physical_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.total_physical_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.total_physical_progress', 0) }}"
                           wire:input="calculateTotalPhysicalGoals">
                    @error('targetEntry.total_physical_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.last_year_physical_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.last_year_physical_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.last_year_physical_progress', 0) }}"
                           wire:input="calculateTotalPhysicalGoals">
                    @error('targetEntry.last_year_physical_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.total_physical_goals" type="number" min="0"
                           class="form-control text-end @error('targetEntry.total_physical_goals') is-invalid @enderror"
                           value="{{ old('targetEntry.total_physical_goals', 0) }}"
                           disabled>
                    @error('targetEntry.total_physical_goals')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.first_quarter_physical_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.first_quarter_physical_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.first_quarter_physical_progress', 0) }}"
                           wire:input="calculatePhysicalQuarter2">
                    @error('targetEntry.first_quarter_physical_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.second_quarter_physical_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.second_quarter_physical_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.second_quarter_physical_progress', 0) }}"
                           wire:input="calculatePhysicalQuarter3">
                    @error('targetEntry.second_quarter_physical_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.third_quarter_physical_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.third_quarter_physical_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.third_quarter_physical_progress', 0) }}"
                           readonly>
                    @error('targetEntry.third_quarter_physical_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>
            </tr>

            <!-- Financial progress row -->
            <tr>
                <td class="fw-medium">{{ __('yojana::yojana.financial') }}</td>

                <td>
                    <input wire:model.lazy="targetEntry.total_financial_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.total_financial_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.total_financial_progress', 0) }}"
                           wire:input="calculateFinancialGoals">
                    @error('targetEntry.total_financial_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.last_year_financial_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.last_year_financial_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.last_year_financial_progress', 0) }}"
                           wire:input="calculateFinancialGoals">
                    @error('targetEntry.last_year_financial_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.total_financial_goals" type="number" min="0"
                           class="form-control text-end @error('targetEntry.total_financial_goals') is-invalid @enderror"
                           value="{{ old('targetEntry.total_financial_goals', 0) }}"
                           disabled>
                    @error('targetEntry.total_financial_goals')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.first_quarter_financial_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.first_quarter_financial_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.first_quarter_financial_progress', 0) }}"
                           wire:input="calculateFinancialQuarter2">
                    @error('targetEntry.first_quarter_financial_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.second_quarter_financial_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.second_quarter_financial_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.second_quarter_financial_progress', 0) }}"
                           wire:input="calculateFinancialQuarter3">
                    @error('targetEntry.second_quarter_financial_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>

                <td>
                    <input wire:model.lazy="targetEntry.third_quarter_financial_progress" type="number" min="0"
                           class="form-control text-end @error('targetEntry.third_quarter_financial_progress') is-invalid @enderror"
                           value="{{ old('targetEntry.third_quarter_financial_progress', 0) }}"
                           readonly>
                    @error('targetEntry.third_quarter_financial_progress')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </td>
            </tr>
            </tbody>

        </table>
    </div>


        <!-- Submit button -->
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">{{ __('yojana::yojana.submit') }}</button>
        </div>
    </form>

    <div class="modal fade" id="processIndicatorModal" tabindex="-1" aria-labelledby="ModalLabel"
         aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="ModalLabel">
                        {{ __('yojana::yojana.create_process_indicator') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            onclick="resetForm()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:yojana.process_indicator_form :action="App\Enums\Action::CREATE" :$plan />
                </div>
            </div>
        </div>
    </div>

</div>
