<x-layout.app header="{{ __('Template') }}">
    <!-- Code display modal -->
    <!-- Bootstrap Modal for displaying card HTML code -->
    <div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="codeModalLabel">Card Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- The <pre> tag preserves the formatting of your HTML code -->
          <pre id="modalCodeContent" style="white-space: pre-wrap;"></pre>
        </div>
      </div>
    </div>
  </div>

    <div class="text-center">
        <h3>{{ __('Services in Digital Palika') }}</h3>
        <p>{{ __('Detailed information of the modules implemented in Digital Lalitpur Municipality') }}</p>

    </div>
    <hr />

    <div class="d-flex flex-wrap justify-content-start" id="icons-container">
        @php
            $cards = [
                [
                    'route' => 'admin.grievance.index',
                    'icon' => 'GunasoByabasthapanIcon.png',
                    'label' => __('Grievance'),
                ],
                [
                    'route' => 'admin.recommendations.dashboard',
                    'icon' => 'YojanaByabasthapanIcon.png',
                    'label' => __('Recommendation'),
                ],
                [
                    'route' => 'admin.meetings.dashboard',
                    'icon' => 'BaithakByabasthapanIcon.png',
                    'label' => __('Meeting'),
                ],
                [
                    'route' => 'admin.digital_board.index',
                    'icon' => 'DigitalLgProfileIcon.png',
                    'label' => __('Digital Citizen Board'),
                ],
                [
                    'route' => 'admin.task-tracking.index',
                    'icon' => 'GharNaksaPassIcon.png',
                    'label' => __('Task Tracking'),
                ],
                ['route' => 'admin.file_records.manage', 'icon' => 'SifarisIcon.png', 'label' => __('Patrachar')],
                [
                    'route' => 'admin.register_files.index',
                    'icon' => 'ByabasayaDartaIcon.png',
                    'label' => __('Register'),
                ],
                ['route' => 'admin.chalani.index', 'icon' => 'YojanaByabasthapanIcon.png', 'label' => __('Chalani')],
                [
                    'route' => 'admin.business-registration.index',
                    'icon' => 'YojanaByabasthapanIcon.png',
                    'label' => __('Business Registration System'),
                ],
                ['route' => 'admin.ebps.index', 'icon' => 'AnudaanByabasthapanIcon.png', 'label' => __('EBPS System')],
                [
                    'route' => 'admin.plan.index',
                    'icon' => 'AnudaanByabasthapanIcon.png',
                    'label' => __('Plan Management System'),
                ],
            ];
        @endphp

        @foreach ($cards as $card)
{{-- <a href="{{ route($card['route']) }}" class="card-link">
                <div class="card icon-card cursor-pointer text-center mb-3 mx-2" style="width: 9rem; height: 9rem;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('assets/icons/' . $card['icon']) }}" alt="{{ $card['label'] }}"
                            class="img-fluid mb-2" style="max-width: 50px; height: auto;">
                        <p class="icon-name text-capitalize text-truncate mb-0 text-wrap w-100"
                            style="white-space: normal; font-size: 0.75rem;">
                            {{ $card['label'] }}
                        </p>
                    </div>
                </div>

            </a> --}}

            <a href="{{ route($card['route']) }}" class="card-link flex-grow-1 mb-3 mx-2 service-item"
                style="max-width: 11rem; min-width: 11rem; display: block;">
                <div class="card text-center h-100" style="height: 100%; cursor: pointer;">
                    <div class="d-flex align-items-center justify-content-center py-4 h-100 w-100">
                        <div class="text-center">
                            <img src="{{ asset('assets/icons/' . $card['icon']) }}" alt="{{ $card['label'] }} Icon"
                                class="img-fluid mb-2 mx-auto" style="max-width: 55px;">
                            <p class="service-card-title text-capitalize mb-0 text-wrap"
                                style="font-size: 1rem; font-weight: 500; white-space: normal;">
                                {{ $card['label'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
@endforeach

    </div>

    <div class="d-flex flex-wrap justify-content-start">


        @foreach ($cards as $card)
{{-- <div class="card icon-card card-link cursor-pointer mb-3 p-3 shadow-sm mx-2"
                style="width: 20rem; height: 8rem; border-radius: 10px;">
                <div class="d-flex justify-content-between align-items-center h-100">

                    <!-- Image and Ward Info -->
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ asset('assets/icons/DigitalLgProfileIcon.png') }}" alt="logo"
                            class="img-fluid mb-1" style="max-width: 50px; height: auto;">
                        <p class="mb-0 text-muted small">Ward No. 1</p>
                    </div>

                    <!-- Name, Contact, and Buttons -->
                    <div class="d-flex flex-column align-items-center text-center">
                        <h6 class="mb-1 fw-bold">Nabin Shrestha</h6>
                        <p class="mb-2 text-muted small">9869064300</p>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm me-1">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div> --}}
            <div class="card icon-card card-link cursor-pointer shadow-sm mb-3 mx-2"
                style="width: 20rem; border-radius: 12px;">
                <div class="d-flex h-100 w-100">
                    <!-- Image Column (30%) -->
                    <div class="d-flex flex-column align-items-center justify-content-center"
                        style="width: 30%; background-color: #f8f9fa;">
                        <a href="#" class="p-2">
                            <img src="{{ asset('assets/icons/DigitalLgProfileIcon.png') }}" alt="logo"
                                class="img-fluid" style="width: 50px; height: 50px;">
                        </a>
                        <p class="mb-0 text-muted small">Ward No 1</p>
                    </div>
                    <!-- Content Column (70%) -->
                    <div class="d-flex flex-column align-items-end justify-content-center p-3" style="width: 70%;">
                        <h6 class="mb-1 fw-bold text-break text-end"
                            style="font-size: 0.95rem; line-height: 1.3; max-height: 5em; overflow: hidden;">
                            Ward No 1
                        </h6>
                        <p class="mb-2 text-muted small text-end">9831737282</p>
                        <div class="d-flex justify-content-end gap-2 mt-1">
                            <a href="#" class="btn btn-primary btn-sm px-2 py-1">
                                <i class="bx bx-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm px-2 py-1">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div id="copy-message"
            style="display: none; position: fixed; bottom: 20px; right: 20px; padding: 10px; background-color: #4CAF50; color: white; border-radius: 5px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        </div>


        <script>
            document.querySelectorAll('.card-link').forEach(link => {
                link.addEventListener('click', async function(e) {
                    // Prevent default action
                    e.preventDefault();

                    // Get the card's HTML
                    const cardHTML = this.outerHTML;

                    // Attempt to copy the card HTML to clipboard
                    try {
                        await navigator.clipboard.writeText(cardHTML);

                        // Show a temporary copy success message (you can keep or remove this)
                        const messageDiv = document.getElementById('copy-message');
                        messageDiv.textContent = 'Card Code copied!';
                        messageDiv.style.backgroundColor = '#4CAF50'; // Green background
                        messageDiv.style.display = 'block';
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 2000);
                    } catch (err) {
                        console.error('Copy failed:', err);
                        const messageDiv = document.getElementById('copy-message');
                        messageDiv.textContent = 'Failed to copy card HTML.';
                        messageDiv.style.backgroundColor = '#f44336'; // Red background
                        messageDiv.style.display = 'block';
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 2000);
                    }

                    // Inject the card HTML into the modal
                    document.getElementById('modalCodeContent').textContent = cardHTML;

                    // Initialize and show the Bootstrap modal
                    let codeModal = new bootstrap.Modal(document.getElementById('codeModal'));
                    codeModal.show();
                });
            });
        </script>


</x-layout.app>
