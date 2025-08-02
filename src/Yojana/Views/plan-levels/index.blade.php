{{-- {{ dd($planLevel) }} --}}
<x-layout.app header="{{ __('yojana::yojana.plan_level_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.plan_level') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.plan_levels') }}</h5>
                    </div>
                    <div>
                        @perm('plan_basic_settings create')
                            <button class="btn btn-info" onclick="resetForm()" data-bs-toggle="modal"
                                data-bs-target="#indexModal">
                                <i class="bx bx-plus"></i> {{ __('yojana::yojana.add_plan_level') }}
                            </button>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:yojana.plan_level_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="planLevelModalLabel">

                        {{ __('yojana::yojana.manage_plan_level') }}
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                        aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card-body">

                        @if (isset($planLevel))
                            <livewire:yojana.plan_level_form :action="App\Enums\Action::UPDATE" :$planLevel />
                        @else
                            <livewire:yojana.plan_level_form :action="App\Enums\Action::CREATE" />
                        @endif
                    </div>
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
