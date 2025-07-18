<x-layout.app header="{{ __('tokentracking::tokentracking.register_token_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tokentracking::tokentracking.register_token') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tokentracking::tokentracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('tokentracking::tokentracking.register_token_list') }}</h5>
                    </div>
                    <div>
                        @perm('register_tokens create')
                            <a href="{{ route('admin.register_tokens.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('tokentracking::tokentracking.add_register_token') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:token_tracking.register_token_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                        aria-label="Close">&times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <livewire:token_tracking.token_feedback_form :action="\App\Enums\Action::CREATE" />

                    </div>
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
        Livewire.on('close-branch-modal', () => {
            $('#branchModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('indexModal'));
            modal.show();
        });
        Livewire.on('show-branch-modal', () => {

            var modal = new bootstrap.Modal(document.getElementById('branchModal'));
            modal.show();
        });
    });

    function resetForm() {
        Livewire.dispatch('reset-form');
    }
    document.getElementById('indexModal').addEventListener('hidden.bs.modal', () => {
        Livewire.dispatch('reset-form');
    });
</script>
