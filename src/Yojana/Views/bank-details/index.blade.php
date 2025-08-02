<x-layout.app header="{{ __('yojana::yojana.bank_detail_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.bank_detail') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.bank_detail_list') }}</h5>
                    </div>
                    <div>
                        @perm('plan_basic_settings create')
                            <a href="{{ route('admin.bank_details.create') }}" class="btn btn-info" onclick="resetForm()"
                                data-bs-toggle="modal" data-bs-target="#indexModal"><i class="bx bx-plus"></i>
                                {{ __('yojana::yojana.add_bank_detail') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:yojana.bank_detail_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalLabel">
                        {{ __('yojana::yojana.manage_bank_details') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <livewire:yojana.bank_detail_form :action="App\Enums\Action::CREATE" />
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
</script>
