<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.plan_by_completion') }}</h4>
        <div class="d-flex gap-2 ms-auto">
{{--            <button type="button" wire:click = "export" class="btn btn-outline-primary btn-sm">--}}
{{--                {{ __('yojana::yojana.export') }}--}}
{{--            </button>--}}
            <button type="button" wire:click="downloadPdf" class="btn btn-outline-primary btn-sm">
                {{ __('yojana::yojana.print') }}
            </button>
        </div>
    </div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="divider divider-primary text-start text-primary fw-bold mx-4 mb-0">
                <div class="divider-text fs-6">{{ __('yojana::yojana.search') }}</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row g-3">


                        {{-- Dropdowns --}}
                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.plan_area') }}</label>
                            <select class="form-select" wire:model="selectedPlanArea">
                                <option value="">{{ __('yojana::yojana.all') }}</option>
                                @foreach ($planAreas as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('selectedPlanArea')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.expense_head') }}</label>
                            <select class="form-select" wire:model="selectedExpenseHead">
                                <option value="">{{ __('yojana::yojana.all') }}</option>
                                @foreach ($expenseHeads as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('selectedExpenseHead')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.project_name') }}</label>
                            <input type="text" wire:model="projectName" name="projectName" id=""
                                class="form-control">
                            <div>
                                @error('selectedExpenseHead')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.ward') }}</label>
                            <select class="form-select" wire:model="selectedWard">
                                <option value="">{{ __('yojana::yojana.all') }}</option>
                                @foreach ($wards as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('selectedWard')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-4 col-12">
                            <label class="form-label">{{ __('yojana::yojana.address') }}</label>
                            <input type="text" wire:model="projectLocation" name="projectLocation" id=""
                                class="form-control">
                            <div>
                                @error('projectLocation')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 d-flex justify-content-center gap-3 mt-4">
                            <button type="button" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                                wire:target="search" wire:click="search">
                                <span wire:loading wire:target="search">
                                    <i class="bx bx-loader bx-spin me-1"></i>
                                </span>
                                <span wire:loading.remove wire:target="search">
                                    <i class="bx bx-search me-1"></i> {{ __('yojana::yojana.search') }}
                                </span>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                                <i class="bx bx-x-circle me-1"></i> {{ __('yojana::yojana.clear') }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div>
        @if ($plans && $plans->count())
            <div class="container mt-4">
                <div class="card shadow table-responsive" id="printContent">
                    <table class="table table-bordered table-striped" id="print-content">
                        <thead>
                            <tr>
                                <th>सि.न.</th>
                                <th>क्षेत्रको नाम</th>
                                <th>खर्च शीर्षक</th>
                                <th>आयोजनाको नाम</th>
                                <th>वडा</th>
                                <th>सम्झौता मिति</th>
                                <th>सम्पन्न मिति</th>
                                <th>विनियोजित बजेट</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBudget = 0;
                            @endphp
                            @foreach ($plans as $index => $row)
                                <tr>
                                    <td>{{ replaceNumbers($index + 1, true) }}</td>
                                    <td>{{ $row->planArea->area_name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $uniqueExpenseHeads = $row->budgetSources
                                                ->pluck('expenseHead.title')
                                                ->filter()
                                                ->unique();
                                        @endphp
                                        {{ $uniqueExpenseHeads->isNotEmpty() ? $uniqueExpenseHeads->implode(', ') : 'N/A' }}
                                    </td>
                                    <td>{{ $row->project_name }}</td>
                                    <td>{{ replaceNumbers($row->ward_id, true) }}</td>

                                    <td>{{ replaceNumbers($row->created_at_nepali, true) ?? 'N/A' }}</td>
                                    <td>
                                        {{ replaceNumbers($row->latestPayment?->payment_date_nepali, true) ?? 'N/A' }}
                                    </td>
                                    {{-- <td>{{ $row->latestPayment?->payment_date ?? 'N/A' }}</td> --}}
                                    <td>{{ replaceNumbers($row->allocated_budget, true) }}</td>
                                    @php $totalBudget += $row->allocated_budget; @endphp
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6"></td>
                                <td class="text-right"><strong>जम्मा</strong></td>
                                <td><strong>{{ replaceNumbers($totalBudget, true) }}</strong></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        @else
            <div class="container mt-4">
                <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                    style="min-height: 200px;">
                    <h5 class="text-center">{{ __('yojana::yojana.no_data_to_show') }}</h5>

                    @error('startDate')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror

                    @error('endDate')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        @endif

    </div>

</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf-in-new-tab', (event) => {
                console.log(event);
                window.open(event.url, '_blank');
            });
        });

        function printDiv() {
            const printContent = document.getElementById('print-content');
            if (!printContent) {
                alert('No content found for printing.');
                return;
            }

            const tableHTML = printContent.outerHTML;
            Livewire.dispatch('print-pdf', {
                tableHtml: tableHTML
            });



        }
    </script>
@endpush
