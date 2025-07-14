<div
    class="flex flex-col sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto mx-2 lg:flex-row gap-0 sm:gap-2 xl:gap-8 font-inter my-6 sm:my-16 md:justify-between md:mx-7 justify-self-center">
    <div class="flex flex-col md:flex-row md:mx-auto w-full sm:gap-4 xl:gap-20">
        <div class="w-full md:w-3/12 px-2">
            <p class="text-base xl:text-2xl text-[#3E3E3E] mx-0 md:mx-0">{{ __('Citizen Charter') }}</p>
            <div class="md:w-full flex flex-col md:flex-row mx-3 md:mx-0 md:justify-between gap-2 md:gap-6 sm:hidden">
                <div class="relative w-full mt-1">
                    <img src="{{ asset('digitalBoard/icons/searchh.png') }}" alt="search"
                        class="absolute left-3 w-4 h-4 top-2">
                    <input type="text" class="text-xs border border-[#AEAEAE] rounded-lg py-2 pl-9 w-full"
                        placeholder="{{ __('Search') }}">
                </div>
                <button
                    class="bg-[#01399A] px-6 py-2 md:px-9 md:py-2 rounded-md md:rounded-lg text-white text-xs md:font-bold w-fit ml-auto ">{{ __('Search') }}</button>
            </div>
            <div class="flex justify-center md:justify-start gap-3 mt-3 w-full">
                <button wire:click="isPalika"
                    class="px-4 py-2 rounded-md text-sm {{ $filterType === 'palika' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-black' }}">
                    {{ __('Palika') }}
                </button>
                <button wire:click="isWard"
                    class="px-4 py-2 rounded-md text-sm {{ $filterType === 'ward' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-black' }}">
                    {{ __('Ward') }}
                </button>
            </div>
            <div class="mx-3 md:mx-0 flex-col gap-1 md:gap-2 mt-6 overflow-y-auto h-[400px] hide-scrollbar hidden md:flex">
                @foreach ($citizenCharters as $charter)
                    <p wire:click="selectCharter({{ $charter->id }})"
                        class="px-8 py-3 rounded-xl text-right text-[14px] md:text-[17px] cursor-pointer 
                            {{ $charter->id == $selectedCharter->id ? 'bg-blue-100' : 'bg-[#F9F9F9] hover:bg-blue-100' }}">
                        {{ $charter->service }}
                    </p>
                @endforeach
            </div>

            <div class="flex mx-3 md:mx-0 flex-col gap-3 mt-8 overflow-y-auto h-[400px] hide-scrollbar md:hidden">
                @foreach ($citizenCharters as $charter)
                    <div class="border-b">
                        <!-- Accordion Header -->
                        <button
                            class="w-full text-left px-6 py-3 rounded-xl text-[14px] md:text-[17px] cursor-pointer 
                            flex justify-between items-center transition-all duration-300 accordion-button
                            {{ $charter->id == $selectedCharter->id ? 'bg-blue-100' : 'bg-[#F9F9F9] hover:bg-blue-100' }}"
                            onclick="toggleAccordion(this)">
                            <span>{{ $charter->service }}</span>
                            <svg class="w-5 h-5 transition-transform duration-300 transform rotate-0" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Accordion Content (Initially Hidden) -->
                        <div
                            class="accordion-content hidden my-2 mx-3 py-3 text-gray-600 transition-all duration-300 rounded rounded-md shadow-md">
                            <div class="flex flex-col mb-4">
                                <p class="bg-gray-200 text-sm font-semibold p-2 rounded-t-lg">
                                    {{ __('Amount') }}
                                </p>
                                <div class="border-l-4 border-slate-500 pl-2">
                                    <p class="mt-2 text-xs leading-relaxed">
                                        {{ $charter->amount }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <p class="bg-gray-200 text-sm font-semibold p-2 rounded-t-lg">
                                    {{ __('Time') }}
                                </p>
                                <div class="border-l-4 border-slate-500 pl-2">
                                    <p class="mt-2 text-xs leading-relaxed">
                                        {{ $charter->time }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col mt-2">
                                <p class="bg-gray-200 text-sm font-semibold p-2 rounded-t-lg">
                                    {{ __('Required Document') }}
                                </p>
                                <div class="border-l-4 border-slate-500 pl-2">
                                    <p class="mt-2 text-xs leading-relaxed">
                                        {!! nl2br(e($charter->required_document)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="w-full hidden md:block md:w-9/12 bg-[#EEF1F8] p-12 pb-7 rounded-md">
            <p class="text-base lg:text-2xl  ">{{ $selectedCharter->service }}</p>
            <div class="flex gap-3 mt-2">
                <button class="px-7 py-1 bg-[#71DD37E5] text-white rounded-md text-sm ">{{ $selectedCharter->amount }}</button>
                <div class="pl-3 pr-32 py-1 bg-white rounded-md flex items-center justify-start text-sm">
                    {{ __('Time') }}:

                    {{ $selectedCharter->time }}
                </div>
            </div>

            <div class="mt-12 text-[#606060] text-base leading-7">
                {!! nl2br(e($selectedCharter->required_document)) !!}
            </div>
        </div>
    </div>
</div>


@section('scripts')
    <script>
        // script for accordion
        function toggleAccordion(button) {
            const allContents = document.querySelectorAll(".accordion-content");
            const allIcons = document.querySelectorAll(".accordion-button svg");

            const content = button.nextElementSibling;
            const icon = button.querySelector("svg");

            // Close all other accordion items
            allContents.forEach((item) => {
                if (item !== content) {
                    item.classList.add("hidden");
                }
            });

            allIcons.forEach((svg) => {
                if (svg !== icon) {
                    svg.classList.remove("rotate-180");
                }
            });

            // Toggle the clicked one
            content.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        }



        // script for custom scrollbar
        document.addEventListener("DOMContentLoaded", function() {
            const scrollableDiv = document.querySelector(".hide-scrollbar");

            // Hide the default scrollbar
            scrollableDiv.style.overflowY = "auto";
            scrollableDiv.style.scrollbarWidth = "none"; // Firefox
            scrollableDiv.style.msOverflowStyle = "none"; // IE & Edge

            // Add custom scrollbar dynamically
            const style = document.createElement("style");
            style.innerHTML = `
        .hide-scrollbar::-webkit-scrollbar {
            width: 6px; /* Width of the custom scrollbar */
        }
        .hide-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1; /* Track background */
            border-radius: 10px;
        }
        .hide-scrollbar::-webkit-scrollbar-thumb {
            background: #888; /* Scrollbar thumb color */
            border-radius: 10px;
        }
        .hide-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555; /* Hover effect */
        }
    `;
            document.head.appendChild(style);
        });
    </script>
@endsection
