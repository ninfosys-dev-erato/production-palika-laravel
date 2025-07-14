<x-layout.app header="Setting List">
        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{__('settings::settings.manage_setting')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{__('settings::settings.list')}}</li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>{{$settingGroup->group_name}} Settings</h3>
            <p>{{$settingGroup->description}}</p>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal"><i class="bx bx-plus"></i>
                {{__('settings::settings.add_setting')}}</button>
        </div>
        <div class="card-body">
           <div class="list-group">
            @foreach($settings as $index => $setting)
                <div class="list-group-item">
                    <livewire:settings.mst_setting_form :$setting :$settingGroup :key="$index" :action="App\Enums\Action::UPDATE"/>
                </div>
            @endforeach
           </div>
        </div>
    </div>
    </div>
        </div>

    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <livewire:settings.mst_setting_form :$settingGroup :action="App\Enums\Action::CREATE" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal', () => {
                var modalElement = document.getElementById('indexModal');
                var modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.show();
            });

            Livewire.on('close-modal', () => {
                var modalElement = document.getElementById('indexModal');
                var modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                    modal.dispose();
                    $('.modal-backdrop').remove();

                }
                document.body.classList.remove('modal-open');
                document.documentElement.style.overflow = 'auto';
                resetForm();
            });


        });

        function resetForm() {
            Livewire.dispatch('reset-form');
        }


    </script>
</x-layout.app>
