<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.plan_goals_summary_report') }}</h4>
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
                            <label class="form-label">{{ __('yojana::yojana.progress_indicators') }}</label>
                            <select class="form-select" wire:model="selectedProgressIndicator">
                                <option value="">{{ __('yojana::yojana.all') }}</option>
                                @foreach ($processIndicators as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('selectedProgressIndicator')
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
        @if ($query && $query->count())
            <div class="container mt-4">
                <div class="card shadow table-responsive" id="printContent">
                    <table class="table table-bordered table-striped" id="print-content">
                        <thead>
                        <tr>
                            <th>सि.न.</th>
                            <th>प्रगति सूचक र इकाई</th>
                            <th>कुल योजना</th>
                            <th>कुल लक्ष्य</th>
                            <th>सम्पन्न लक्ष्य</th>
                            <th>कुल लक्ष्य</th>
                            <th>सम्पन्न लक्ष्य</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($query as $index => $row)
                            <tr>
                                <td>{{ replaceNumbers($index + 1, true) }}</td>
                                <td>{{ $row->title . ' ( '. $row->unit->symbol .' )' }}</td>
                                <td>{{ replaceNumbers($row->targetEntries->count('plan'), true) }}</td>
                                @php
                                    $totalPhysicalGoals = $row->targetEntries
                                        ->filter(fn($entry) => is_null($entry->deleted_at))
                                        ->sum(fn($entry) => floatval($entry->total_physical_goals));

                                    $totalFinancialGoals = $row->targetEntries
                                        ->filter(fn($entry) => is_null($entry->deleted_at))
                                        ->sum(fn($entry) => floatval($entry->total_financial_goals));
                                @endphp

                                <td>{{ replaceNumbers($totalPhysicalGoals, true)        }}</td>
                                <td>{{ replaceNumbers($totalFinancialGoals, true)       }}</td>
                                <td>{{ replaceNumbers($row->targetEntries->whereNull('deleted_at')->sum('completed_physical_goals'), true)      }}</td>
                                <td>{{ replaceNumbers($row->targetEntries->whereNull('deleted_at')->sum('completed_financial_goals'), true)         }}</td>
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
