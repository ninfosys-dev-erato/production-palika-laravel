<x-layout.app header="Additional Form Setting List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.additional_form_settings') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('ebps::ebps.additional_form_settings') }}
                    </h5>
                    @perm('ebps_settings create')
                        <button class="btn btn-info" data-bs-toggle="modal" onclick="resetForm()"
                            data-bs-target="#indexModal">
                            <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_additional_form_setting') }}
                        </button>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.additional_form_setting_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="indexModal" tabindex="-1" aria-labelledby="AddAdditionalFormSettingsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddAdditionalFormSettingsModalLabel">
                        {{ __('ebps::ebps.additional_form_settings') }}
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <livewire:ebps.additional_form_setting_form :action="App\Enums\Action::CREATE" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', () => {
            $('#indexModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    });
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('indexModal'));
            modal.show();
        });
    });

    function resetForm() {
        Livewire.dispatch('reset-form');
    }

    $('#indexModal').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open').css({
            'overflow': '',
            'padding-right': ''
        });
    });
</script>
