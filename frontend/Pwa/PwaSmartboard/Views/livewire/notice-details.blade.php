@php
    $fileExtension = $selectedNotice && $selectedNotice->file ? strtolower(pathinfo($selectedNotice->file, PATHINFO_EXTENSION)) : null;
@endphp
<div class="d-flex h-100 w-100 pt-3">
    <div class="d-flex flex-column h-100 " style="width: 25%;">
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
                    <span class="text-primary" style="font-size: 0.8rem">१
                    </span>
                </div>
                <p class="m-0" style="font-size: 0.8rem">सूचनाहरु</p>
            </div>
        </div>
        <div style="overflow-y:auto; height: 90%;" wire:poll.5s>
            @foreach ($notices as $key => $notice)
                <div wire:click="showNoticeDetail({{ $notice->id }})" wire:key="notice-{{ $notice->id }}" wire:poll.5s
                    class="w-100 rounded-2 mt-2 px-2 py-2 d-flex flex-column cursor-pointer shadow-sm notice-item {{ $selectedNotice->id === $notice->id ? 'active' : '' }}"
                    data-notice-id="{{$key}}" style="cursor: pointer">
                    <p class="m-0 " style="font-size: 0.8rem">{{$notice->title}}</p>
                    @if($notice->date)
                        <p class=" m-0  text-secondary" style="font-size: 0.65rem ">प्रकाशित मिति : {{$notice->date }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>


    <div class="h-100 pb-3 d-flex flex-column ms-3" style="width: 75%">
        <div class="rounded-1 overflow-hidden" style="height: 90%">
            @if ($selectedNotice && $fileExtension === 'pdf')

                <div class="pdf-viewer-container h-100">
                    <iframe
                        src="https://docs.google.com/gview?embedded=true&url={{ urlencode(asset('storage/digital-board/notices/' . $selectedNotice->file)) }}"
                        style="height: 100%; width:100%; padding: 0 5rem; -webkit-overflow-scrolling: touch;"
                        class="rounded-lg shadow-lg border-0"></iframe>
                </div>
            @elseif ($selectedNotice && $selectedNotice->file)
                <div class="d-flex w-100 h-100 justify-content-center">
                    <img src="{{ asset('storage/digital-board/notices/' . $selectedNotice->file) }}" alt="notice"
                        class="h-100">
                </div>
            @else
                <div class="d-flex w-100 h-100 justify-content-center align-items-center">
                    <div class="d-flex justify-content-center align-items-center text-center w-100 p-3"
                        style="height: 100%;">
                        <div class="alert alert-info" style="width:70%" role="alert">
                            <h5 class="fw-bold">सूचनाहरू उपलब्ध छैनन्</h5>
                            <p class="m-0">अहिलेसम्म कुनै सूचना अपलोड गरिएको छैन। कृपया पछि फेरि जाँच गर्नुहोस्।</p>
                        </div>

                    </div>
                </div>
            @endif
        </div>
        @if ($selectedNotice)
            <p id="noticeTitle" class="m-0 mt-2 d-flex justify-content-center fw-medium mt-2" style="color: var(--primary)">
                {{$selectedNotice->title}}
            </p>
        @endif
    </div>
    <style>
        .notice-item {
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .notice-item:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
        }

        .notice-item.active {
            background-color: var(--primary) !important;
            color: #fff !important;
        }

        .notice-item.active p {
            color: #fff !important;
        }

        #pdf-container {
            scroll-behavior: smooth;
            padding: 0 16rem;
        }

        .pdf-page {
            background: white;
            margin: 0 auto;
            page-break-after: always;
        }

        /* Center pages horizontally */
        .pdf-page canvas {
            display: block;
            margin: 0 auto;
        }
    </style>
</div>