@push('styles')
    <link rel="stylesheet" href="{{ asset('home') }}/ejalasstyle.css">
@endpush
<div>
    <div class="bg-white border border-gray-200 p-4">

        <!-- Registration Number -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <i class="bx bx-file text-primary me-2 main-icon-size"></i>
                <h4 class="text-primary fw-bold mb-0 mt-1">
                    Complaint Registration No: {{ $complaintRegistration->reg_no }}
                </h4>
            </div>
            <span class="badge px-3 py-2 bg-{{ $complaintRegistration->status?->color() }}">
                {{ $complaintRegistration->status?->label() }}
            </span>
        </div>

        <!-- Row 1 -->
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex align-items-center mb-2">
                <i class="bx bx-calendar text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Fiscal Year:</strong>
                <span>{{ $complaintRegistration->fiscalYear?->year ?? '-' }}</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <i class="bx bx-time text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Registration Date:</strong>
                <span>{{ $complaintRegistration->reg_date }}</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <i class="bx bx-error-circle text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Priority:</strong>
                <span>{{ $complaintRegistration->priority?->name ?? '-' }}</span>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex align-items-center mb-2">
                <i class="bx bx-map-pin text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Registration Address:</strong>
                <span>{{ $complaintRegistration->reg_address?->label() ?? '-' }}</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <i class="bx bx-map-alt text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Dispute Area:</strong>
                <span>{{ $complaintRegistration->disputeMatter?->disputeArea?->title ?? '-' }}
                    ({{ $complaintRegistration->disputeMatter?->title ?? '-' }})</span>
            </div>
        </div>

        <!-- Row 3 -->
        <div class="d-flex justify-content-between mb-3">
            <div class=" d-flex align-items-center mb-2">
                <i class="bx bx-user text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Complainers:</strong>
                <span>{{ $complaintRegistration->complainers?->pluck('name')->implode(', ') ?? '-' }}</span>
            </div>
            <div class=" d-flex align-items-center mb-2">
                <i class="bx  bx-user text-primary me-2 sub-icon-size"></i>
                <strong class="me-1">Defenders:</strong>
                <span>{{ $complaintRegistration->defenders?->pluck('name')->implode(', ') ?? '-' }}</span>
            </div>
        </div>

    </div>

    <div x-data="{
        activeTab: window.location.hash ? window.location.hash.substring(1) : 'tab1',
        setTab(tabId) {
            this.activeTab = tabId;
            window.location.hash = tabId;
        }
    }" x-init="window.addEventListener('hashchange', () => {
        activeTab = window.location.hash.substring(1);
    });">
        <!-- Tabs -->
        <ul class="nav custom-blue-tabs nav-background border border-gray-200 mt-3" id="myTab" role="tablist">
            <template
                x-for="(tab, index) in [
            { id: 'tab1', label: '{{ __('ejalas::ejalas.dispute_registration') }}' },
            { id: 'tab2', label: '{{ __('ejalas::ejalas.dispute_deadline') }}' },
            { id: 'tab3', label: '{{ __('ejalas::ejalas.court_notice') }}' },
            { id: 'tab4', label: '{{ __('ejalas::ejalas.hearing_schedule') }}' },
            { id: 'tab5', label: '{{ __('ejalas::ejalas.response_registration') }}' },
            { id: 'tab6', label: '{{ __('ejalas::ejalas.mediator_selection') }}' },
            { id: 'tab7', label: '{{ __('ejalas::ejalas.witness_representative') }}' },
            { id: 'tab8', label: '{{ __('ejalas::ejalas.legal_document') }}' },
            { id: 'tab9', label: '{{ __('ejalas::ejalas.settlement') }}' },
            { id: 'tab10', label: '{{ __('ejalas::ejalas.fulfilled_conditions') }}' },
            { id: 'tab11', label: '{{ __('ejalas::ejalas.case_records') }}' },
            { id: 'tab12', label: '{{ __('ejalas::ejalas.court_submission') }}' }
        ]"
                :key="tab.id">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" :class="{ 'active': activeTab === tab.id }" type="button"
                        x-text="tab.label" @click="setTab(tab.id)">
                    </button>
                </li>
            </template>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content mt-3 p-0">
            <!-- Tab 1 -->
            <div x-show="activeTab === 'tab1'" x-cloak>
                <livewire:ejalas.dispute_registration_court_form :complaintRegistration="$complaintRegistration" />
            </div>

            <!-- Lazy-load other tabs -->
            <template x-if="activeTab === 'tab2'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.dispute_deadline_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab3'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.court_notice_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab4'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.hearing_schedule_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab5'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.written_response_registration_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab6'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.mediator_selection_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab7'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.witnesses_representative_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab8'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.legal_document_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab9'">
                <livewire:ejalas.settlement_form :complaintRegistration="$complaintRegistration" />
            </template>

            <template x-if="activeTab === 'tab10'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.fulfilled_condition_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab11'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.case_record_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

            <template x-if="activeTab === 'tab12'">
                <div class="card mt-3">
                    <div class="card-body">
                        <livewire:ejalas.court_submission_form :complaintRegistration="$complaintRegistration" />
                    </div>
                </div>
            </template>

        </div>
    </div>
    @push('scripts')
        <script>
            function toggleDisputeDeadlineForm() {
                Livewire.dispatch('toggleDisputeDeadlineForm');
            }
        </script>

        <script>
            function initNepaliDatePickers() {
                console.log('Initializing Nepali date pickers...');

                document.querySelectorAll('.nepali-date').forEach(input => {

                    if (!input || typeof input.nepaliDatePicker !== 'function') return;

                    // Skip already initialized inputs
                    if (input.classList.contains('ndp-initialized')) return;

                    // Store current value and clear it temporarily to avoid parsing issues
                    const currentValue = input.value || '';

                    // Temporarily clear the value to prevent parsing errors
                    input.value = '';

                    // Destroy existing picker if present
                    if (input._nepaliDatePicker) {
                        try {
                            input._nepaliDatePicker.destroy();
                            input._nepaliDatePicker = null;
                        } catch (_) {}
                    }

                    // Initialize picker with empty value first
                    try {
                        input.nepaliDatePicker({
                            language: "ne",
                            ndpYear: true,
                            ndpMonth: true,
                            unicodeDate: true,
                            onChange: () => {
                                // Dispatch input event so Livewire picks up the change
                                input.dispatchEvent(new Event('input', {
                                    bubbles: true
                                }));
                            }
                        });

                        // Now set the value after picker is initialized
                        if (currentValue && currentValue.trim() !== '') {
                            // Use setTimeout to ensure picker is fully ready
                            setTimeout(() => {
                                try {
                                    input.value = currentValue;
                                    // Trigger the picker to update its display
                                    if (input._nepaliDatePicker && input._nepaliDatePicker.setDate) {
                                        input._nepaliDatePicker.setDate(currentValue);
                                    }
                                } catch (e) {
                                    console.warn('Could not set date value:', currentValue, e);
                                }
                            }, 200);
                        }

                        // Mark as initialized
                        input.classList.add('ndp-initialized');
                        console.log('Nepali date picker initialized for:', input.id || input.name);

                    } catch (error) {
                        console.error('Nepali date picker init failed for', input.id || input.name, error);
                        // Remove the initialized class so it can be retried
                        input.classList.remove('ndp-initialized');
                    }
                });
            }

            function setupLivewireDatePickers() {
                initNepaliDatePickers();

                if (typeof Livewire !== 'undefined') {
                    // Custom event from Livewire component
                    Livewire.on('init-registration-date', () => {
                        setTimeout(() => initNepaliDatePickers(), 100);
                    });

                    // Initialize after any Livewire DOM update
                    Livewire.hook('message.processed', () => {
                        setTimeout(() => initNepaliDatePickers(), 100);
                    });
                } else {
                    // Retry setup if Livewire is not yet loaded
                    setTimeout(setupLivewireDatePickers, 500);
                }
            }

            // Run on initial DOM ready
            document.addEventListener('DOMContentLoaded', () => {
                setupLivewireDatePickers();
            });

            // Also ensure initialization after Livewire fully loads
            document.addEventListener('livewire:load', () => {
                setupLivewireDatePickers();
            });

            // Optional: re-initialize on Bootstrap tabs or modals if your datepicker is inside them
            document.addEventListener('shown.bs.tab', () => {
                setTimeout(() => initNepaliDatePickers(), 100);
            });

            document.addEventListener('shown.bs.modal', () => {
                setTimeout(() => initNepaliDatePickers(), 100);
            });
        </script>
    @endpush
</div>
