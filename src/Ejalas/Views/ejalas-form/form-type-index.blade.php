<x-layout.app header="{{ __('ejalas::ejalas.ejalas_form_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ejalas::ejalas.ejalas_forms') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ejalas::ejalas.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.ejalas_forms') }}</h5>
                    </div>
                    <div>
                    @perm('jms_settings create')
                            <!-- <a href="{{ route('admin.ejalas.form-template-type.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('ejalas::ejalas.add_ejalas_form') }}</a> -->
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal"
                                    onclick="resetForm()">
                                    <i class="bx bx-plus"></i>
                                    {{ __('ejalas::ejalas.add_ejalas_form') }}
                                </button>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:ejalas.form_type_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>


<div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">
                    {{-- @if ($action === App\Enums\Action::UPDATE)
                        {{ __('businessregistration::businessregistration.edit_department') }}
                    @else
                        {{ __('businessregistration::businessregistration.add_department') }}
                    @endif --}}
                </h5>
                <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                    aria-label="Close">&times;
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

        
                    <livewire:ejalas.form_type_form :action="App\Enums\Action::CREATE" />
                 
                </div>
            </div>
        </div>
    </div>
</div>

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
    document.getElementById('indexModal').addEventListener('hidden.bs.modal', () => {
        Livewire.dispatch('reset-tokenFeedback-form');
    });
</script>