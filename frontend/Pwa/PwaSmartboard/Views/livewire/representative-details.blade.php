<div class="d-flex h-100 w-100 pt-3">
    <div class="d-flex flex-column" style="width: 25%;">
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
        <div class="w-100 d-flex justify-content-between align-items-center rounded-2 px-2 py-1 text-light mt-2"
            style="background-color: var(--secondary)">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                    style="height: 1.2rem; width: 1.2rem;">
                    <span class="text-primary" style="font-size: 0.8rem">४
                    </span>
                </div>
                <p class="m-0" style="font-size: 0.8rem">जनप्रतिनिधिहरु</p>
            </div>
        </div>
    </div>

    <div class="h-100 pb-3 d-flex flex-column align-items-center ms-3" style="width: 75%">
        <div class="w-75 h-100 my-4 mx-3">
            <div class="d-flex justify-content-center mb-4  rounded-1" style="background-color: var(--primary)">
                <p class="fw-medium text-white py-1 m-0">जनप्रतिनिधिहरुको विवरण</p>
            </div>

            <div class="d-flex justify-content-between align-items-center" style="height: 90%; overflow: hidden;">
                <button id="prevButton" onclick="handlePrev()" class="btn p-0 border-0 bg-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                        <path fill-rule="evenodd"
                            d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 .708 0z" />
                    </svg>
                </button>

                <div class="representative-grid ms-2" style="overflow: hidden" wire:poll.5s>
                    @foreach ($representatives as $index => $rep)
                        <div class="representative-profile m-2" data-index="{{ $index }}"
                            wire:key="representative-{{ $rep->id }}">
                            <div class="card rounded-1 shadow-sm border-0 overflow-hidden">
                                <div class="w-100 d-flex justify-content-center" style="height: 4rem">
                                    <img src="{{ customAsset(config('src.Employees.employee.photo_path'), $rep->photo) }}"
                                        class="h-100" style="width: fit-content;" alt="{{ $rep->name }}">
                                </div>
                                <div class="card-body text-center">
                                    <p class="mb-0 text-dark" style="font-size: 0.7rem;">{{ $rep->name }}</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.6rem;">
                                        {{$rep->designation->title ?? 'No Designation'  }}
                                    </p> <!-- Correct designation -->
                                    <p class="mb-0 text-muted" style="font-size: 0.5rem;">{{ $rep->phone }}</p>
                                    <!-- Correct phone -->
                                    <p class="mb-0 text-muted" style="font-size: 0.4rem;">{{ $rep->email }}</p>
                                    <!-- Correct email -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button id="nextButton" onclick="handleNext()" class="btn ms-2 p-0 border-0 bg-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z" />
                        <path fill-rule="evenodd"
                            d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <style>
        .representative-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            width: 100%;
        }

        .representative-profile {
            transition: transform 0.3s ease;
            display: none;
        }

        .representative-profile:hover {
            transform: scale(1.05);
        }

        button:disabled {
            color: #cccccc !important;
            cursor: not-allowed;
        }

        button:not(:disabled):hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>

    <script>
        let currentPage = 0;
        const itemsPerPage = 12;

        function showPage(page) {
            const start = page * itemsPerPage;
            const end = start + itemsPerPage;
            const profiles = document.querySelectorAll('.representative-profile');

            profiles.forEach((profile, index) => {
                profile.style.display = (index >= start && index < end) ? 'block' : 'none';
            });
        }

        function updateButtonStates() {
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const totalPages = Math.ceil({{ count($representatives) }} / itemsPerPage);

            prevButton.disabled = currentPage === 0;
            nextButton.disabled = currentPage >= totalPages - 1;
        }

        function handlePrev() {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
                updateButtonStates();
            }
        }

        function handleNext() {
            const totalPages = Math.ceil({{ count($representatives) }} / itemsPerPage);
            if (currentPage < totalPages - 1) {
                currentPage++;
                showPage(currentPage);
                updateButtonStates();
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            showPage(0);
            updateButtonStates();
        });
    </script>
</div>