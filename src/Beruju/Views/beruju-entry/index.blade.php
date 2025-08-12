<x-layout.app header="{{ __('beruju::beruju.beruju_management') }}">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="text-primary fw-bold">{{ __('beruju::beruju.beruju_entries') }}</h5>
            <div>
                @perm('beruju create')
                    <a href="{{ route('admin.beruju.create') }}" class="btn btn-info">
                        <i class="bx bx-plus"></i> {{ __('beruju::beruju.add_beruju') }}
                    </a>
                @endperm
            </div>
        </div>
        <div class="card-body">
            <livewire:beruju.beruju_entry_table theme="bootstrap-4" />
        </div>
    </div>
</x-layout.app>
