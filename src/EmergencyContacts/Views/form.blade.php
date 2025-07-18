<x-layout.app header="EmergencyContact  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('emergencycontacts::emergencycontacts.emergencycontact') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($emergencyContact))
                    {{ __('emergencycontacts::emergencycontacts.create') }}
                @else
                    {{ __('emergencycontacts::emergencycontacts.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                @if (isset($emergencyContact))
                    <livewire:emergency_contacts.emergency_contact_form :$action :$emergencyContact />
                @else
                    <livewire:emergency_contacts.emergency_contact_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
