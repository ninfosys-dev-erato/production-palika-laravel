<div class="row mb-6">
    <label class="col-sm-2 col-form-label"
        for="basic-default-name">{{ App::getLocale() == 'en' ? $setting->label : $setting->label_ne }}</label>
    <div class="col-sm-8">
        @if (count($options) < 1)
            <input type="text" wire:model.live="setting.value" class="form-control">
        @else
            <select name="" id="{{ $setting->key }}_select" wire:model="setting.key_id"
                wire:change="updateKey($event.target.value)" class="form-control select2">
                <option value="">{{ __('settings::settings.select_an_option') }}</option>
                @foreach ($options as $key => $option)
                    <option value="{{ $key }}">{{ $option }}</option>
                @endforeach
            </select>
        @endif
    </div>
    @if ($setting->isDirty())
        <div class="col-sm-2">
            <button type="button" class="btn rounded-pill btn-icon btn-outline-success" wire:click="save">
                <span class="tf-icons bx bx-check bx-30px"></span>
            </button>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize select2 for this setting with explicit width
            let selectElement = $("#{{ $setting->key }}_select");
            selectElement.select2({
                width: '100%' // Force select2 to use 100% width of its container
            });

            selectElement.on("change", function(e) {
                @this.call('updateKey', e.target.value);
            });

            // Listen for when any Bootstrap tab is shown
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                // Get the target tab's selector from the button attribute
                var targetTab = $(e.target).attr("data-bs-target");
                // Find all select2 elements in the now visible tab and reinitialize them
                $(targetTab).find('.select2').each(function() {
                    // Destroy and reinitialize select2 to force a recalculation of width
                    $(this).select2('destroy').select2({
                        width: '100%'
                    });
                });
            });
        });
    </script>
@endpush
