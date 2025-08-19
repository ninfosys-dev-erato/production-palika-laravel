<x-layout.app header="EBPS Filter Setting">
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="{{ route('admin.ebps.map_applies.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back to Applications
        </a>
    </div>

    <livewire:ebps.ebps_filter_manager />
</x-layout.app> 