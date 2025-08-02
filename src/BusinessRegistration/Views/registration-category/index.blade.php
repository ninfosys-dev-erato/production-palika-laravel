<x-layout.app header="Registration Category">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.registration_category') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('businessregistration::businessregistration.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold">
                            {{ __('businessregistration::businessregistration.registration_categories') }}</h5>
                        <div>
                            @perm('business_settings create')
                                {{-- <a href="{{ route('admin.business-registration.registration-category.create') }}"
                                    class="btn btn-info"><i class="bx bx-plus"></i>
                                    {{ __('businessregistration::businessregistration.add_registration_category') }}</a> --}}
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal"
                                    onclick="resetForm()">
                                    <i class="bx bx-plus"></i>
                                    {{ __('businessregistration::businessregistration.add_registration_category') }}
                                </button>
                            @endperm
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:business_registration.registration_category_table theme="bootstrap-4" />
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

                    {{-- @if (isset($checkAction))
                        <livewire:business_registration.business_nature_form :action="App\Enums\Action::UPDATE"
                            :$businessNature />
                    @else --}}
                    <livewire:business_registration.registration_category_form :action="App\Enums\Action::CREATE" />
                    {{-- @endif --}}
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
        Livewire.dispatch('reset-form');
    });
</script>
