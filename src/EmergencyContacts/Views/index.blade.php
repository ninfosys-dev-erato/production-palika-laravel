<x-layout.app header="{{ __('emergencycontacts::emergencycontacts.emergencycontact_list') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('emergencycontacts::emergencycontacts.emergencycontact') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('emergencycontacts::emergencycontacts.list') }}
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    {{ __('emergencycontacts::emergencycontacts.emergencycontact_list') }}

                    @perm('emergency_contact create')
                        <div>
                            <a href="{{ route('admin.emergency-contacts.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('emergencycontacts::emergencycontacts.add_emergencycontact') }}</a>

                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:emergency_contacts.emergency_contact_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
