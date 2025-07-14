<div class="d-flex h-100 w-100 pt-3 program-container">
    <div class="d-flex flex-column h-100" style="width: 25%;">
        <a wire:click="goBack" class="text-decoration-none text-dark  mb-2" style="cursor: pointer;">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                    <path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z">
                    </path>
                </svg>
                <p class="fw-medium fs-6 m-0 ms-1">फिर्ता</p>
            </div>
        </a>
        <div class="w-100 d-flex justify-content-between align-items-center rounded-2 px-2 py-1 text-light mb-2"
            style="background-color: var(--secondary)">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                    style="height: 1.2rem; width: 1.2rem;">
                    <span class="text-primary" style="font-size: 0.8rem">२
                    </span>
                </div>
                <p class="m-0" style="font-size: 0.8rem">कार्यक्रमहरु</p>
            </div>
        </div>

        <div style="overflow-y:auto; height: 90%;" wire:poll.5s>
            @foreach ($programs as $key => $program)
                <div wire:key="program-{{ $program->id }}" wire:click="showProgramDetail({{ $program->id }})"
                    class="w-100 mt-2 rounded-2 px-2 py-2 d-flex flex-column cursor-pointer shadow-sm program-item {{ $selectedProgram->id === $program->id ? 'active' : '' }}"
                    data-program-id="{{$key}}" style="cursor: pointer">
                    <p class="m-0" style="font-size: 0.8rem">{{$program->title}}</p>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Replace the content section with this -->
    <div class="h-100 pb-3 d-flex flex-column ms-3" style="width: 75%">
        @if($programs->isEmpty())
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="alert alert-info" style="width:70%" role="alert">
                    <h5 class="fw-bold text-center">कार्यक्रमहरू उपलब्ध छैनन्</h5>
                    <p class="m-0 text-center">अहिलेसम्म कुनै कार्यक्रम अपलोड गरिएको छैन। कृपया पछि फेरि जाँच गर्नुहोस्।</p>
                </div>
            </div>
        @else
            <div class="w-100 h-100 d-flex justify-content-center rounded-1 overflow-hidden" style="height: 90%">
                <img id="programPhoto"
                    src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $selectedProgram->photo) }}"
                    class="h-100" alt="{{$selectedProgram->title}}">
            </div>
            <p id="programTitle" class="m-0 d-flex mt-2 justify-content-center fw-medium" style="color: var(--primary)">
                {{ $selectedProgram->title }}
            </p>
        @endif
    </div>
    <style>
        .program-container .program-item {
            background-color: #fff !important;
            transition: all 0.3s ease !important;
        }

        .program-container .program-item:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }

        .program-container .program-item.active {
            background-color: var(--primary) !important;
        }

        .program-container .program-item.active p {
            color: #fff !important;
        }
    </style>
</div>