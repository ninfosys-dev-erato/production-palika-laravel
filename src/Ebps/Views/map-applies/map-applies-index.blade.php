<x-layout.app header="MapApply List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.map_apply') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('ebps::ebps.map_applications') }}
                    </h5>

                    <div>
                        <a href="{{ route('admin.ebps.map_applies.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i>
                            {{ __('ebps::ebps.add_map_apply') }}</a>
                    </div>

                </div>
                <div class="card-body">
                    <livewire:ebps.map_apply_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalLabel">
                        {{ __('ebps::ebps.choose_oraganization') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModal()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:ebps.choose_organization />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>

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
