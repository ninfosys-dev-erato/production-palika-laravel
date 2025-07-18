<x-layout.app header="Form Create {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Setting</a>
            </li>
            <li class="breadcrumb-item"><a href="#">Form</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Template
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $form->title }} {{ __('settings::settings.template') }}
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-info"><i class="bx bx-list-ol">
                            </i>Form List</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:settings.form_template :$action :$form :$modules />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
