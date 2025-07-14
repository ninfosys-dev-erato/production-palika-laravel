<div>
    @php
        $statusColors = [
            'rejected' => 'bg-danger-subtle text-danger border border-2 border-danger',
            'processing' => 'bg-warning-subtle text-warning border border-2 border-warning',
            'skipping' => 'bg-secondary-subtle text-secondary text-decoration-line-through',
            'complete' => 'bg-success-subtle text-success border border-2 border-success',
        ];
    @endphp

    <main class="flex-grow-1 w-100 px-4 my-3">
        <div class="bg-white rounded shadow-lg border overflow-hidden " style="height: 80%; overflow: hidden;">
            <div class="row g-0 text-white fw-bold position-sticky top-0"
                style="z-index: 10; background-color: var(--primary)">
                <div class="col-1 p-3 border-end" style="font-size: 1rem">टोकन नं.</div>
                <div class="col-2 p-2 border-end" style="font-size: 1rem">सेवाग्राहीको नाम</div>
                <div class="col-1 p-3 border-end" style="font-size: 1rem">सेवाको किसिम</div>
                <div class="col-2 p-3 border-end" style="font-size: 1rem">सम्बन्धित शाखाहरु</div>
                <div class="col-1 p-3 border-end" style="font-size: 1rem">लाग्ने समय</div>
                <div class="col-1 p-3 border-end" style="font-size: 1rem">समय</div>
                <div class="col-4 p-3">
                    <div class="row g-2">
                        <div class="col text-center" style="font-size: 0.9rem">प्रवेश</div>
                        <div class="col text-center" style="font-size: 0.9rem">तोक आदेश</div>
                        <div class="col text-center" style="font-size: 0.9rem">दर्ता</div>
                        <div class="col text-center" style="font-size: 0.9rem">वर्गीकरण</div>
                        <div class="col text-center" style="font-size: 0.9rem">सम्पादन</div>
                        {{-- <div class="col text-center" style="font-size: 0.9rem">गुनासो</div>
                        <div class="col text-center" style="font-size: 0.9rem">प्रतिक्रिया</div> --}}
                    </div>
                </div>
            </div>

            <div id="scroll-container" class="overflow-auto"
                style="height:65vh; max-height: 65vh; scrollbar-width: none; -ms-overflow-style: none;  background-color: white)">
                <div id="table-content" class="border-top border-gray-200">
                    @if (!is_null($tokens))
                        @foreach ($tokens as $key => $token)
                            <div wire:poll.3s="loadTokens" wire:poll.keep-alive wire:key="row-{{ $key }}"
                                class="row g-0 border-top transition"
                                style="background-color:rgba(227, 240, 255, 0.67);">
                                <div class="col-1 p-3 border-end d-flex align-items-center overflow-hidden">
                                    <span class="fw-medium text-dark text-truncate w-100" style="font-size: 1rem">
                                        {{ $token->token }}
                                    </span>
                                </div>

                                <div class="col-2 p-3 border-end d-flex align-items-center">
                                    <span class="fw-medium text-dark text-wrap" style="font-size: 1rem">
                                        {{ $token->tokenHolder?->name }}
                                    </span>
                                </div>

                                <div class="col-1 p-3 border-end d-flex align-items-center">
                                    <span class="text-dark" style="font-size: 1rem">{{ $token->token_purpose->label() }}
                                    </span>
                                </div>

                                <div class="col-2 p-2 border-end">
                                    <div class="d-flex flex-wrap overflow-hidden h-100 align-items-center">
                                        {{ is_null($token->getBranchFlowString()) ? $token->currentBranch->title : $token->getBranchFlowString() }}
                                    </div>
                                </div>

                                <div class="col-1 p-3 border-end d-flex align-items-center justify-content-center">
                                    <span class="text-dark" style="font-size: 1rem">
                                        {{ replaceNumbers((string) $token->estimated_time, true) }} मिनेट
                                    </span>
                                </div>

                                <div class="col-1 p-3 border-end d-flex align-items-center justify-content-center">
                                    <span class="font-monospace text-dark" style="font-size: 1rem">
                                        {{ $token->entry_time . ' - ' . $token->exit_time }}
                                    </span>
                                </div>

                                <div class="col-4 p-3">
                                    <div class="row g-2">
                                        @foreach ($token->stageStatus as $k => $stage)
                                            @php
                                                $colorClass =
                                                    $statusColors[$stage->status] ?? 'bg-secondary-subtle text-dark';
                                            @endphp
                                            <div class="col d-flex h-100 justify-content-center align-items-center"
                                                wire:key="{{ $stage->status . $k . $key }}">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow {{ $colorClass }}"
                                                    style="width:2.5rem; height:2.5rem; font-size: 0.9rem;">
                                                    {{ replaceNumbers((string) ($loop->index + 1), true) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 border-start border-5 border-primary  p-3 w-100 shadow"
            style="background-color: var(--primary-lighter); border-color: var(--primary);">
            <p class="mb-0" style="color: var(--primary); font-size: 1rem;">कृपया आफ्नो टोकन नम्बर अनुसार प्रतीक्षा
                गर्नुहोस्</p>
        </div>
    </main>

    <style>
        #scroll-container::-webkit-scrollbar {
            display: none;
        }

        .transition {
            transition: background-color 0.15s ease-in-out;
        }

        .transition:hover {
            background-color: var(--bs-primary-bg-subtle);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                console.log(window.Livewire); // Check if Livewire is properly initialized

                setInterval(() => {
                    if (window.Livewire) {
                        Livewire.dispatch('refreshTokens');
                    }
                }, 3000);
                const scrollContainer = document.getElementById("scroll-container");

                if (!scrollContainer) return;

                const scrollSpeed = 100;
                const step = 1;
                let scrolling = true;

                function autoScroll() {
                    if (!scrolling) return;

                    if (scrollContainer.scrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight) {
                        scrollContainer.scrollTop = 0; // Reset to top
                    } else {
                        scrollContainer.scrollTop += step;
                    }
                }

                const scrollInterval = setInterval(autoScroll, scrollSpeed);

                scrollContainer.addEventListener("mouseenter", () => {
                    scrolling = false;
                });

                scrollContainer.addEventListener("mouseleave", () => {
                    scrolling = true;
                });
            });
        </script>
    @endpush

</div>
