{{-- <x-layout.app header="User">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ $action->value === 'create' ? __('Add Users' . ($selectedward ? ' for Ward ' . $selectedward : '')) : __('wards::wards.update_user') }}
            </h5>
            <a href="{{ route('admin.users.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('wards::wards.user_list') }}</a>
        </div>
        <div class="card-body">
            @if (isset($user))
                <livewire:wards.user_form :$action :$user :$selectedward />
            @else
                <livewire:wards.user_form :$action :$selectedward />
            @endif
        </div>
    </div>
</x-layout.app> --}}
