<?php

namespace Src\Settings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Settings\DTO\LetterHeadSampleAdminDto;
use Src\Settings\Models\LetterHeadSample;
use Src\Settings\Service\LetterHeadSampleAdminService;

class LetterHeadSampleForm extends Component
{
    use SessionFlash;

    public ?LetterHeadSample $letterHeadSample;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'letterHeadSample.name' => ['required', 'string', 'max:255'],
            'letterHeadSample.content' => ['required', 'string'],
            'letterHeadSample.slug' => ['required', 'string', 'max:255'],
            'letterHeadSample.style' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'letterHeadSample.name.required' => __('settings::settings.the_name_field_is_required'),
            'letterHeadSample.name.string' => __('settings::settings.the_name_must_be_a_string'),
            'letterHeadSample.name.max' => __('settings::settings.the_name_may_not_be_greater_than_255_characters'),
            'letterHeadSample.content.required' => __('settings::settings.the_content_field_is_required'),
            'letterHeadSample.content.string' => __('settings::settings.the_content_must_be_a_string'),
            'letterHeadSample.slug.required' => __('settings::settings.the_slug_field_is_required'),
            'letterHeadSample.slug.string' => __('settings::settings.the_slug_must_be_a_string'),
            'letterHeadSample.slug.max' => __('settings::settings.the_slug_may_not_be_greater_than_255_characters'),
            'letterHeadSample.style.string' => __('settings::settings.the_style_must_be_a_string'),
        ];
    }

    public function render()
    {
        return view("Settings::livewire.letterHeadSample.form");
    }

    public function mount(LetterHeadSample $letterHeadSample, Action $action): void
    {
        $this->letterHeadSample = $letterHeadSample;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = LetterHeadSampleAdminDto::fromLiveWireModel($this->letterHeadSample);
        $service = new LetterHeadSampleAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('settings::settings.letter_head_sample_created_successfully'));
                break;
            case Action::UPDATE:
                $service->update($this->letterHeadSample, $dto);
                $this->successFlash(__('settings::settings.letter_head_sample_updated_successfully'));
                break;
        }
        return redirect()->route('admin.letter-head-sample.index');
    }
}
