<?php

namespace Src\Ebps\Livewire;

use App\Traits\MapApplyTrait;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Src\Ebps\DTO\MapApplyStepAdminDto;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\MapApplyStepAdminService;
use Src\Settings\Models\Form;

class BuildingRegistrationApplyStepForm extends Component
{
    use SessionFlash, WithFileUploads, MapApplyTrait;

    public ?MapStep $mapStep = null;
    public ?MapApply $mapApply = null;
    public bool $preview = true;
    public array $letters = [];
    public array $data = [];
    public bool $edit = false;
    public bool $generate = false;
    public string $activeTab = 'preview';

    public function mount(MapStep $mapStep, MapApply $mapApply)
    {
        $this->mapStep = MapStep::with(['form', 'constructionTypes'])->find($mapStep->id);

        $this->mapApply = $mapApply;

        if (!$this->mapStep) {
            return;
        }

        foreach ($this->mapStep->form as $form) {
            // if (!empty($form->fields)) {
            //     $this->setFields($form->id);
            // }

            $mapApplyStep = MapApplyStep::with('mapApplyStepTemplates')
                ->where('map_step_id', $mapStep->id)
                ->first();

            $mapApplyStepTemplate = $mapApplyStep
                ? $mapApplyStep->mapApplyStepTemplates->firstWhere('form_id', $form->id)
                : null;

            $this->letters[$form->id] = $mapApplyStepTemplate
                ? $mapApplyStepTemplate->template
                : $this->resolveMapStepTemplate($this->mapApply, $this->mapStep, $form);
        }
    }

    // public function setFields(int|string $formId): void
    // {
    //     if (!is_numeric($formId)) {
    //         $this->data[$formId] = [];
    //         return;
    //     }

    //     $form = Form::find($formId);
    //     if (!$form || empty($form->fields)) {
    //         $this->data[$formId] = [];
    //         return;
    //     }

    //     $this->data[$formId] = collect(json_decode($form->fields, true))->mapWithKeys(function ($field) {
    //         if ($field['type'] === "table") {
    //             $field['fields'] = [];
    //             $row = [];
    //             foreach ($field as $key => $values) {
    //                 if (is_numeric($key)) {
    //                     $row[$values['slug']] = $values;
    //                     unset($field[$key]);
    //                 }
    //             }
    //             $field['fields'][] = $row;
    //         }
    //         return [$field['slug'] => $field];
    //     })->toArray();
    // }


    public function resetLetter($formId)
    {
        $form = Form::where('id',$formId)->first();
        $formId = $form->id;
        if (isset($this->letters[$formId])) {
            $this->letters[$formId] = $this->resolveMapStepTemplate($this->mapApply, $this->mapStep, $form);
            $this->dispatch('update-editor-' . $formId, ['content' => $this->letters[$formId]]);
            $this->successToast(__('ebps::ebps.reset_successfully'));
        }
    }

    public function updateLetter($formId, $content)
    {
        $this->letters[(int)$formId] = $content;
    }

    public function togglePreview()
    {
        $this->preview = !$this->preview;
        // Switch to preview tab when toggling preview mode
        if ($this->preview) {
            $this->activeTab = 'preview';
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function save($formId, $data = null)
    {
        try{
            $service = new MapApplyStepAdminService();
                $dto = MapApplyStepAdminDto::fromLiveWireModel($formId, $this->letters[$formId], $this->mapApply, $this->mapStep);
                $service->saveOrUpdate($dto, $data);

            $this->successToast(__('ebps::ebps.saved_successfully'));
            return redirect()->route('admin.ebps.building-registrations.step', ['id'=>$this->mapApply->id]);

        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    public function render()
    {
        return view("Ebps::livewire.map-applies.map-applies-print");
    }

    public function saveAndGenerate($formId)
    {
        try{
            $data = $this->getFormattedData($formId);
            $form = Form::find($formId);

            $mapApplyStepTemplate = MapApplyStepTemplate::where('form_id', $formId)->first();

            if ($mapApplyStepTemplate) {
            $mapApplyStepTemplate->update([
                'data' => json_encode($data),
                'template' => $this->letters[$formId]
            ]);
            $this->successToast(__('ebps::ebps.saved_successfully'));
            }else{
                $this->save($formId, $data);
            }

            $this->letters[$formId] = $this->resolveMapStepTemplate($this->mapApply, $this->mapStep, $form);
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(((__('ebps::ebps.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

    private function getFormattedData($formId): array
    {
        $processedData = [];
        if (!isset($this->data[$formId])) {
            return [];
        }

        foreach ($this->data[$formId] as $fieldSlug => $fieldValue) {
            // Extract field definition for the given fieldSlug
            $fieldDefinition = collect($this->data[$formId])->firstWhere('slug', $fieldSlug);

            $processedData[$fieldSlug] = array_merge($fieldDefinition ?? [], [
                'value' => $fieldValue['value'] ?? null,
                'label' => $fieldDefinition['label'] ?? 'Default Label',
            ]);
        }

        return $processedData;
    }

    
}
