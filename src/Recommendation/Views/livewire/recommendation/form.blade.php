<form wire:submit.prevent="save">
    <!-- Step Indicator -->
    <div class="wizard-header mb-4">
        <h5>{{ __('recommendation::recommendation.step') }} {{ replaceNumbersWithLocale($step, true) }} /
            {{ replaceNumbersWithLocale($maxPages, true) }}</h5>
    </div>

    @switch($step)
        @case(1)
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('recommendation::recommendation.title') }}" id="title"
                            name="initialRecommendation.title" dusk='title'
                            placeholder="{{ __('recommendation::recommendation.title') }}" />
                    </div>

                    <div class="col-md-6" wire:ignore>
                        <label
                            for="recommendation_category_id">{{ __('recommendation::recommendation.recommendation_category') }}</label>
                        <select dusk="recommendation-initialRecommendation.recommendation_category_id-field"
                            id="recommendation_category_id" name="initialRecommendation.recommendation_category_id"
                            class="form-select select2-component @error('initialRecommendation.recommendation_category_id') is-invalid @enderror"
                            wire:model="initialRecommendation.recommendation_category_id" class="form-select" required>
                            <option value="" hidden>
                                {{ __('recommendation::recommendation.choose_recommendation_category') }}</option>
                            @foreach (\Src\Recommendation\Models\RecommendationCategory::whereNull('deleted_by')->get() as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('initialRecommendation.recommendation_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6" wire:ignore>
                        <label for="form_id">{{ __('recommendation::recommendation.form') }}</label>
                        <select dusk="recommendation-initialRecommendation.form_id-field" id="form_id"
                            name="initialRecommendation.form_id" wire:model="initialRecommendation.form_id"
                            class="form-select select2-component @error('initialRecommendation.form_id') is-invalid @enderror"
                            required>
                            <option value="" hidden>{{ __('recommendation::recommendation.choose_form_template') }}
                            </option>
                            @foreach (\Src\Settings\Models\Form::where('deleted_by')->where('module', 'Recommendation')->get() as $form)
                                <option value="{{ $form->id }}">{{ $form->title }}</option>
                            @endforeach
                        </select>
                        @error('form_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-form.text-input label="{{ __('recommendation::recommendation.revenue') }}" id="revenue"
                            type="number" :min="0" dusk='revenue' name="initialRecommendation.revenue"
                            placeholder="{{ __('recommendation::recommendation.revenue') }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.checkbox-input dusk='is_ward_recommendation' id="is_ward_recommendation"
                            name="is_ward_recommendation" :options="[
                                'is_ward_recommendation' => __('recommendation::recommendation.is_ward_recommendation'),
                            ]" />
                    </div>
                </div>
            </div>
        @break

        @case(2)
            <div class="card-body">
                <livewire:recommendation.partial_role_manage_form :$recommendation :$action wire:model="selectedRoles" />
            </div>
        @break

        @case(3)
            <div class="card-body">
                <livewire:recommendation.partial_recommendation_department_manage :$recommendation :$action
                    wire:model="selectedDepartments" />

            </div>
        @break

        @case(4)
            <div class="card-body">
                <livewire:recommendation.recommendation_signees_manage :$recommendation />
            </div>
        @break

    @endswitch

    <!-- Navigation Buttons -->
    <div class="card-footer d-flex justify-content-between mt-3">
        @if ($step > 1)
            <button type="button" wire:click.prevent="previousPage" class="btn btn-secondary"
                wire:loading.attr="disabled">{{ __('recommendation::recommendation.previous') }}
            </button>
        @endif

        @if ($step < $maxPages)
            @if ($step === 3)
                <button type="button" wire:click.prevent="save" class="btn btn-primary" wire:loading.attr="disabled">
                    {{ __('recommendation::recommendation.save') }}
                </button>
            @else
                <button type="button" wire:click.prevent="nextPage" class="btn btn-primary"
                    wire:loading.attr="disabled">
                    {{ __('recommendation::recommendation.next_page') }}
                </button>
            @endif
        @else
            <button type="button" wire:click.prevent="redirectToIndex" class="btn btn-primary"
                wire:loading.attr="disabled">
                {{ __('recommendation::recommendation.submit') }}
            </button>
        @endif
    </div>


</form>

@script
    <script>
        $(document).ready(function() {

            const recommendationCategorySelect = $('#recommendation_category_id');
            const formSelect = $('#form_id');

            recommendationCategorySelect.select2();
            formSelect.select2();

            recommendationCategorySelect.on('change', function() {
                @this.set('initialRecommendation.recommendation_category_id', $(this).val());

            })

            formSelect.on('change', function() {
                @this.set('initialRecommendation.form_id', $(this).val());

            })
        })
    </script>
@endscript
