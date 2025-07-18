<?php

namespace Src\Settings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FiscalYears\Service\FiscalYearAdminService;
use Src\Settings\DTO\LetterHeadAdminDto;
use Src\Settings\Models\LetterHead;
use Src\Settings\Service\LetterHeadAdminService;

class LetterHeadForm extends Component
{

    use SessionFlash;

    public ?LetterHead $letterHead;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'letterHead.header' => ['required'],
            'letterHead.footer' => ['required'],
            'letterHead.ward_no' => ['required', 'integer', 'between:1,31'],
            'letterHead.is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'letterHead.header.required' => __('settings::settings.the_header_field_is_required'),
            'letterHead.footer.required' => __('settings::settings.the_footer_field_is_required'),
            'letterHead.ward_no.required' => __('settings::settings.the_ward_number_field_is_required'),
            'letterHead.ward_no.integer' => __('settings::settings.the_ward_number_must_be_an_integer'),
            'letterHead.ward_no.between' => __('settings::settings.the_ward_number_must_be_between_1_and_31'),
            'letterHead.is_active.required' => __('settings::settings.the_active_status_field_is_required'),
            'letterHead.is_active.boolean' => __('settings::settings.the_active_status_must_be_true_or_false'),
        ];
    }

    public function updated()
    {
        $this->skipRender();
        $this->validate();
    }

    public function render()
    {
        return view("Settings::livewire.letterHead.form");
    }

    public function mount(LetterHead $letterHead, Action $action): void
    {
        $this->letterHead = $letterHead;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = LetterHeadAdminDto::fromLiveWireModel($this->letterHead);
        $service = new LetterHeadAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('settings::settings.letter_head_created_successfully'));
                break;
            case Action::UPDATE:
                $service->update($this->letterHead, $dto);
                $this->successFlash(__('settings::settings.letter_head_updated_successfully'));
                break;
        }
        return redirect()->route('admin.setting.letter-head.index');
    }
}
