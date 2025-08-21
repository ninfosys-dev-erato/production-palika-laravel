<div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <input wire:model.live="search" type="text" class="form-control rounded-0" placeholder="{{ __('beruju::beruju.search_sub_categories') }}">
                <button class="btn btn-outline-secondary rounded-0" type="button">
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary rounded-0" wire:click="$set('perPage', 10)">10</button>
                <button type="button" class="btn btn-outline-secondary rounded-0" wire:click="$set('perPage', 25)">25</button>
                <button type="button" class="btn btn-outline-secondary rounded-0" wire:click="$set('perPage', 50)">50</button>
                <button type="button" class="btn btn-outline-secondary rounded-0" wire:click="$set('perPage', 100)">100</button>
            </div>
        </div>
    </div>

    {{ $this->table }}

    <script>
        function deleteSubCategory(id) {
            if (confirm('{{ __('beruju::beruju.confirm_delete') }}')) {
                window.location.href = '{{ route('admin.beruju.sub-categories.index') }}/destroy/' + id;
            }
        }
    </script>
</div>
