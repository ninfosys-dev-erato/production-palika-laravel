<div class="bg-light border rounded shadow-md p-4 mb-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap border-bottom">
        <div class="d-flex align-items-center mb-sm-0 mb-3">
            <div class="avatar">
                <div
                    class="w-12 h-12 rounded-circle bg-blue-600 text-white flex items-center justify-center text-lg font-bold">
                    {{ substr($log->applicant_name, 0, 1) }}
                </div>
            </div>

            <div class="flex-grow-1 ms-1">
                <div>
                    <span class="badge bg-label-primary">
                        {{ __($log->status) }}
                    </span>
                </div>
                <h6 class="m-0 fw-normal">{{ $log->sender?->display_name ?? '' }}</h6>

                @if ($log->receiver)
                    <small class="text-body">{{ __('filetracking::filetracking.to') }}: <span
                            class="font-semibold">{{ $log->receiver?->display_name ?? '' }}</span></small>
                @endif
            </div>
        </div>`
        <div class="d-flex align-items-center">
            <p class="mb-0 me-4 text-body-secondary">{{ $log->created_at->diffForHumans() }}</p>
            @if ($log->file)
                <span class="btn btn-icon"><i class="icon-base bx bx-paperclip icon-md cursor-pointer"></i></span>
            @endif
        </div>
    </div>


    <!-- Notes Section -->
    <p class="mt-3 text-gray-800 border-b pb-2">{{ __($log->notes) }}</p>

    <!-- File Display -->
    @if ($log->file)
        <div class="mt-4">
            @php
                $fileExt = pathinfo($log->file, PATHINFO_EXTENSION);
            @endphp

            @if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <img src="{{ $log->file_address }}" alt="Image" class="d-block w-50">
            @elseif ($fileExt == 'pdf')
                <embed src="{{ $log->file_address }}" type="application/pdf" class="w-full rounded-lg shadow-sm">
            @elseif (in_array($fileExt, ['mp4', 'webm', 'ogg']))
                <video controls class="w-full h-auto max-w-md mx-auto rounded-lg shadow-sm">
                    <source src="{{ $log->file_address }}" type="video/{{ $fileExt }}">
                </video>
            @else
                <a href="{{ $log->file_address }}" target="_blank"
                    class="inline-flex items-center justify-center px-4 py-2 mt-4 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition duration-300">
                    <i class="bx bx-download mr-2"></i> {{ __('filetracking::filetracking.download_file') }}
                </a>
            @endif
        </div>
    @endif

</div>
