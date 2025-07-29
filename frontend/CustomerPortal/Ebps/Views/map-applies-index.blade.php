<x-layout.customer-app header="MapApply List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.map_apply') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('Map Apply List') }}</h5>
                    </div>

                    <div>
                        <a href="{{ route('customer.ebps.apply.map-apply.create') }}" class="btn btn-info"><i
                                class="fa fa-plus"></i>
                            {{ __('ebps::ebps.add_map_apply') }}</a>

                    </div>
                </div>
                <div class="card-body">
                    <livewire:customer_portal.ebps.customer_map_apply_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="orgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orgModalLabel">
                        {{ __('ebps::ebps.choose_oraganization') }}
                    </h5>

                    <button type="button" class="btn-close"onclick="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:customer_portal.ebps.choose_organization />
                </div>
            </div>
        </div>
    </div>

</x-layout.customer-app>



<script>
    let selectedMapApplyId = null;

    window.addEventListener('open-choose-organization-modal', event => {
        selectedMapApplyId = event.detail.id;

        const myModal = new bootstrap.Modal(document.getElementById('indexModal'), {
            keyboard: false
        });
        myModal.show();

        Livewire.dispatch('setMapApplyId', [selectedMapApplyId]);

    });
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            $('#indexModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    });

    function closeModal() {
        Livewire.dispatch('close-modal');
    }
</script>
