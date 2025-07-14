<?php

namespace Src\Settings\Livewire;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Settings\DTO\FormAdminDto;
use Src\Settings\Enums\ModuleEnum;
use Src\Settings\Service\FormAdminService;
use App\Enums\Action;
use Illuminate\Support\Facades\Route;

class FormForm extends Component
{
    public $action;
    public $select=[];
    public $fields = [];
    public $form = [];
    public $modules = [];
    public $path;
    public $types = [
        'text' => 'Text',
        'email' => 'Email',
        'number' => 'Number',
        'tel' => 'Telephone',
        'url' => 'URL',
        'select' => 'Select',
        'checkbox' => 'Checkbox',
        'radio' => 'Radio',
        'file' => 'File',
        'table' => 'Table',
        'group' => 'Group',
    ];

    public bool $show_module = true;


    public function rules(): array
    {
        return [
            'form.id' => ['nullable'],
            'form.title' => ["required", "string", "max:255"],
            'form.template' => ["nullable", "string"],
            'form.module' => ["required", Rule::in(array_map(fn($enum) => $enum->value, ModuleEnum::cases()))],
            'form.fields' => ["nullable", "array"],
            'form.fields.*.type' => ["required", "string"],
            'form.fields.*.label' => ["required", "string"],
            'form.fields.*.slug' => [
                'required',
                'string',
                'regex:/^(?![-_])[a-z0-9]+(?:[-_][a-z0-9]+)*(?<![-_])$/'
            ],
            'form.fields.*.default_value' => ["nullable", "string"],
            'form.fields.*.helper_text' => ["nullable", "string"],
            'form.fields.*.is_required' => ["boolean"],
            'form.fields.*.is_readonly' => ["boolean"],
            'form.fields.*.is_disabled' => ["boolean"],
            'form.fields.*.is_multiple' => ["boolean"],
        ];
    }
    public function messages(): array
    {
        return [
            'form.title.required' => __('settings::settings.the_title_field_is_required'),
            'form.title.string' => __('settings::settings.the_title_must_be_a_string'),
            'form.title.max' => __('settings::settings.the_title_must_not_be_greater_than_255_characters'),
            'form.module.required' => __('settings::settings.the_module_field_is_required'),
            'form.module.in' => __('settings::settings.the_selected_module_is_invalid'),
        ];
    }

    public function mount($action, $form = [], $modules = [])
    {
        $this->modules = $modules;
        $this->action = $action;
        $this->form = $form;
        $this->path = request()->path();

        $currentRouteName = Route::currentRouteName();

        foreach ($modules as $module) {
            if (str_contains($currentRouteName, strtolower($module))) {
                $this->modules = [$module => $module];
                $this->form['module'] = $module;

                $this->show_module =!$this->show_module;
                break;
            }
        }



        $formFiltered = array_filter($this->form, function($key) {
            return !in_array($key, ['id', 'title', 'module']);
        }, ARRAY_FILTER_USE_KEY);

        $result = array_merge(...$formFiltered);
        if($result){
        foreach ($result as $key => $value) {
            $this->form[$key] = $value;
            $selectedValue = $value['type'] ?? null;
            $this->addField(type: $selectedValue);
            $this->onSelect(
                index: $key,
                selectedValue: $selectedValue
            );
            if(array_key_exists('option',$value)){
                foreach($value['option'] as $k => $v){
                    $this->addOptionListItem(
                        index: $key
                    );
                }
            }

                if($selectedValue === 'table'){
                    $value = array_filter($value, function($key) {
                        return !in_array($key, ['type']);
                    }, ARRAY_FILTER_USE_KEY);
                    foreach ($value as $index => $item) {

                        if (is_array($item)) {
                            $selectedSubValue = $item['type'];
                            $this->addTableField($key, $selectedSubValue);
                            $this->onSelect(
                                index: $key,
                                subIndex: $index,
                                selectedValue: $selectedSubValue
                            );
                            if(array_key_exists('option',$item)){
                                foreach($item['option'] as $k => $v){
                                    $this->addOptionListItem(
                                        index: $key,nestedIndex: $index
                                    );
                                }
                            }

                        }
                    }
                }
                if($selectedValue === 'group'){
                    $value = array_filter($value, function($key) {
                        return !in_array($key, ['type']);
                    }, ARRAY_FILTER_USE_KEY);
                    foreach ($value as $index => $item) {

                        if (is_array($item)) {
                            $selectedSubValue = $item['type'];
                            $this->addGroupField($key, $selectedSubValue);
                            $this->onSelect(
                                index: $key,
                                subIndex: $index,
                                selectedValue: $selectedSubValue
                            );
                            if(array_key_exists('option',$item)){
                                foreach($item['option'] as $k => $v){
                                    $this->addOptionListItem(
                                        index: $key,nestedIndex: $index
                                    );
                                }
                            }

                        }
                    }
                }
        }
    }
    }

    public function render()
    {
        return view("Settings::livewire.form.form");
    }
    public function onselect($index, $subIndex = null, $selectedValue = null)
    {
        if (isset($subIndex)) {
            if (isset($this->form[$index][$subIndex]['type'])) {
                $selectedValue = $this->form[$index][$subIndex]['type'];

                if ($selectedValue !== "") {
                    $this->fields[$index]['fields'][$subIndex]['content'] = $this->generateFieldHtml($selectedValue, "{$index}.{$subIndex}");
                }
            }
        } else {
            if ($selectedValue === null && isset($this->form[$index]['type'])) {
                $selectedValue = $this->form[$index]['type'];
            }

            if (!empty($selectedValue)) {
                $this->fields[$index]['content'] = $this->generateFieldHtml($selectedValue, $index);
            }
        }
    }

    public function onTextSelect($index,$subIndex = null)
    {
        if(isset($subIndex)){
            $selectedValue = $this->form[$index][$subIndex]['input_type'];
            if($selectedValue !== ""){
                $this->fields[$index]['fields'][$subIndex]['content']= $this->generateTextType($selectedValue,"{$index}.{$subIndex}");
            }
        }else{
            $selectedValue = $this->form[$index]['input_type'];
            if($selectedValue !== ""){
                $this->fields[$index][0]['content']= $this->generateTextType($selectedValue,$index);
            }
        }

    }

    public function generateTextType($value,$index)
    {
        switch ($value){
            case 'text':
                return '<div class="row mt-2">
                         <div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <label for="">Select Input Type</label>
                         <select
                         name="input_type"
                         id=""
                         wire:change="onTextSelect('.str_replace('.',',',$index).')"
                         class="form-control form-control-sm"
                           wire:model="form.{{ $index }}.input_type">
                         <option value="text">Text</option>
                         <option value="email">Email</option>
                         <option value="number">Number</option>
                         <option value="tel">Tel</option>
                         <option value="url">URL</option>
                         </select>
                         </div>
                         <div class="col-md-3">
                         <label for="">Label</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.label"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Slug">Slug</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.slug"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Default Value">Default Value</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.default_value"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Placeholder</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.placeholder"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Helper Text</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.helper_text"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Max Length</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.max_length"
                         >
                         </div>
                         <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'email':
                return '<div class="row mt-2">
                         <div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <label for="">Select Input Type</label>
                         <select
                         name="input_type"
                         id=""
                         wire:change="onTextSelect('.str_replace('.',',',$index).')"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.input_type">
                         <option value="text">Text</option>
                         <option value="email">Email</option>
                         <option value="number">Number</option>
                         <option value="tel">Tel</option>
                         <option value="url">URL</option>
                         </select>
                         </div>
                         <div class="col-md-3">
                         <label for="">Label</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.label"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Slug">Slug</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.slug"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Default Value">Default Value</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.default_value"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Placeholder</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.placeholder"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Helper Text</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.helper_text"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Max Length</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.max_length"
                         >
                         </div>
                         <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                          <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                         <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                          <div class="col-md-3">
                        <label for="">Does this field have multiple value?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_multiple" name="is_multiple" value="yes" class="form-check-input" id="mulitipled_yes_{{ $index }}">
                        <label class="form-check-label" for="mulitipled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_multiple" name="is_multiple" value="no" class="form-check-input" id="multipled_no_{{ $index }}">
                        <label class="form-check-label" for="multipled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                         </div>
                         </div>
                         </div>';
            case 'number':
                return '<div class="row mt-2">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                        <label for="">Input Type</label>
                        <select
                        name="input_type"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.input_type"
                        wire:change="onTextSelect('.str_replace('.',',',$index).')">
                        <option value="text">Text</option>
                        <option value="number" selected>Number</option>
                        <option value="tel">Tel</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label for="">Label</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.label">
                        </div>
                        <div class="col-md-3">
                        <label for="Slug">Slug</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.slug">
                        </div>
                        <div class="col-md-3">
                        <label for="Default Value">Default Value</label>
                        <input type="number"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.default_value">
                        </div>
                        <div class="col-md-3">
                        <label for="">Placeholder</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.placeholder">
                        </div>
                        <div class="col-md-3">
                        <label for="">Helper Text</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.helper_text">
                        </div>
                        <div class="col-md-3">
                        <label for="">Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Max-Length</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.max">
                        </div>
                        <div class="col-md-3">
                        <label for="">Min</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.min">
                        </div>
                        <div class="col-md-3">
                        <label for="">Steps</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.steps">
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'tel':
                return '<div class="row mt-2">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                        <label for="">Input Type</label>
                        <select
                        name="input_type"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.input_type"
                        wire:change="onTextSelect('.str_replace('.',',',$index).')">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="tel" selected>Tel</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label for="">Label</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.label">
                        </div>
                        <div class="col-md-3">
                        <label for="Slug">Slug</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.slug">
                        </div>
                        <div class="col-md-3">
                        <label for="Default Value">Default Value</label>
                        <input type="number"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.default_value">
                        </div>
                        <div class="col-md-3">
                        <label for="">Placeholder</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.placeholder">
                        </div>
                        <div class="col-md-3">
                        <label for="">Helper Text</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.helper_text">
                        </div>
                        <div class="col-md-3">
                        <label for="">Max-Length</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.max-length">
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required_'.$index.'" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required_'.$index.'" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'"" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'"" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'"" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'url':
                return '<div class="row mt-2">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                        <label for="">Input Type</label>
                        <select
                        name="input_type"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.input_type"
                        wire:change="onTextSelect('.str_replace('.',',',$index).')">
                        <option value="text">Text</option>
                        <option value="number" >Number</option>
                        <option value="tel">Tel</option>
                        <option value="email">Email</option>
                        <option value="url" selected >URL</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label for="">Label</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.label">
                        </div>
                        <div class="col-md-3">
                        <label for="Slug">Slug</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.slug">
                        </div>
                        <div class="col-md-3">
                        <label for="Default Value">Default Value</label>
                        <input type="number"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.default_value">
                        </div>
                        <div class="col-md-3">
                        <label for="">Placeholder</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.placeholder">
                        </div>
                        <div class="col-md-3">
                        <label for="">Helper Text</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.helper_text">
                        </div>
                        <div class="col-md-3">
                        <label for="">Max-Length</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.max-length">
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>

                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>';
        }
    }
    public function addField($type= null)
    {
        $index = count($this->fields);
        $this->fields[]['type']= $this->addItem(index: $index,selectedValue: $type);
    }

    public function addTableField($index, $selectedValue = null)
    {
        $subIndex = isset($this->fields[$index]['fields']) ? count($this->fields[$index]['fields']) : 0;
        $this->fields[$index]['fields'][$subIndex]['type']= $this->addTableItem($index,$subIndex);
    }

    public function addGroupField($index, $selectedValue = null)
    {
        $subIndex = isset($this->fields[$index]['fields']) ? count($this->fields[$index]['fields']) : 0;
        $this->fields[$index]['fields'][$subIndex]['type']= $this->addGroupItem($index,$subIndex);
    }

    public function addTableItem($index, $subIndex = null,$selectedValue = null)
    {
        $wireModel = $subIndex !== null ? "wire:model=\"form.{$index}.{$subIndex}.type\"" : "wire:model=\"form.{$index}.type\"";
        $change = $subIndex !== null ? "wire:change=\"onselect($index, $subIndex)\"" : "wire:change=\"onselect($index)\"";
        return '<div class="row">
                <div class="col-md-3">
                <div><label class="form-label" for="type">Type</label>
                <div class="input-group">
                    <select id="type" class="form-control" '.$wireModel.' name="type" '.$change.'>
                        <option value="">Select Input Type</option>
                        <option '.(($selectedValue === "text")? 'selected':'').' value="text">Text</option>
                        <option '.(($selectedValue === "select")? 'selected':'').' value="select">Select</option>
                        <option '.(($selectedValue === "file")? 'selected':'').' value="file">File</option>

                    </select>
                    <span class="input-group-text"> <em class="bi bi-caret-down">▼</em> </span>
                </div>
                 </div>
                </div>
                <div class="col-md-6">&nbsp;</div>
                <div class="col-md-3">
                <button wire:click="removeField(' . $index . ($subIndex !== null ? ", $subIndex" : "") . ')" type="button" class="btn btn-sm btn-danger">
                <i class="bx bx-trash"></i>
                </button></div>
             </div>';
    }
    public function addGroupItem($index, $subIndex = null,$selectedValue = null)
    {
        $wireModel = $subIndex !== null ? "wire:model=\"form.{$index}.{$subIndex}.type\"" : "wire:model=\"form.{$index}.type\"";
        $change = $subIndex !== null ? "wire:change=\"onselect($index, $subIndex)\"" : "wire:change=\"onselect($index)\"";
        return '<div class="row">
                <div class="col-md-3">
                <div><label class="form-label" for="type">Type</label>
                <div class="input-group">
                    <select id="type" class="form-control" '.$wireModel.' name="type" '.$change.'>
                        <option value="">Select Input Type</option>
                       <option '.(($selectedValue === "text")? 'selected':'').' value="text">Text</option>
                        <option '.(($selectedValue === "select")? 'selected':'').' value="select">Select</option>
                        <option '.(($selectedValue === "checkbox")? 'selected':'').' value="checkbox">Checkbox</option>
                        <option '.(($selectedValue === "radio")? 'selected':'').' value="radio">Radio</option>
                        <option '.(($selectedValue === "file")? 'selected':'').' value="file">File</option>
                    </select>
                    <span class="input-group-text"> <em class="bi bi-caret-down">▼</em> </span>
                </div>
                 </div>
                </div>
                <div class="col-md-6">&nbsp;</div>
                <div class="col-md-3">
                <button wire:click="removeField(' . $index . ($subIndex !== null ? ", $subIndex" : "") . ')" type="button" class="btn btn-sm btn-danger">
                <i class="bx bx-trash"></i>
                </button></div>
             </div>';
    }
    public function addItem($index, $subIndex = null,$selectedValue = null)
    {
        $wireModel = $subIndex !== null ? "wire:model=\"form.{$index}.{$subIndex}.type\"" : "wire:model=\"form.{$index}.type\"";
        $change = $subIndex !== null ? "wire:change=\"onselect($index, $subIndex)\"" : "wire:change=\"onselect($index)\"";
        return '<div class="row">
                <div class="col-md-3">
                <div><label class="form-label" for="type">Type</label>
                <div class="input-group">
                    <select id="type" class="form-control" '.$wireModel.' name="type" '.$change.'>
                        <option value="">Select Input Type</option>
                        <option '.(($selectedValue === "text")? 'selected':'').' value="text">Text</option>
                        <option '.(($selectedValue === "select")? 'selected':'').' value="select">Select</option>
                        <option '.(($selectedValue === "checkbox")? 'selected':'').' value="checkbox">Checkbox</option>
                        <option '.(($selectedValue === "radio")? 'selected':'').' value="radio">Radio</option>
                        <option '.(($selectedValue === "file")? 'selected':'').' value="file">File</option>
                        <option '.(($selectedValue === "table")? 'selected':'').' value="table">Table</option>
                        <option '.(($selectedValue === "group")? 'selected':'').' value="group">Group</option>
                    </select>
                    <span class="input-group-text"> <em class="bi bi-caret-down">▼</em> </span>
                </div>
                 </div>
                </div>
                <div class="col-md-6">&nbsp;</div>
                <div class="col-md-3">
                <button wire:click="removeField(' . $index . ($subIndex !== null ? ", $subIndex" : "") . ')" type="button" class="btn btn-sm btn-danger">
                <i class="bx bx-trash"></i>
                </button></div>
             </div>';
    }

    public function addOptionListItem($index, $nestedIndex= null)
    {
       if(isset($nestedIndex)){
           $subIndex = (isset($this->fields[$index]['fields'][$nestedIndex]['options']))?count($this->fields[$index]['fields'][$nestedIndex]['options']):0;
           $this->fields[$index]['fields'][$nestedIndex]['options'][$subIndex] =
               '<tr>
             <td>'.($subIndex+1).'</td>
             <td>
             <div>
             <label for="label" class="form-label"></label>
             <input type="text" class="form-control " id="label" name="form.option.label" wire:model="form.'.$index.'.'.$nestedIndex.'.option.'.$subIndex.'.label" value="" placeholder="" aria-describedby="label-helper">
             </div>
             </td>
             <td>
             <div>
             <label for="value" class="form-label"></label>
             <input type="text" class="form-control " id="value" name="form.option.value" wire:model="form.'.$index.'.'.$nestedIndex.'.option.'.$subIndex.'.value" value="" placeholder="" aria-describedby="value-helper">
             </div>
             </td>
             <td>
             <button class="btn btn-sm btn-outline-danger" type="button" wire:click="removeOption('.$index.','.$subIndex.','.$nestedIndex.')"><i class="bx bx-trash-alt" ></i></button>
             </td>
             </tr>';
       }else{
           $subIndex = (isset($this->fields[$index]['options']))?count($this->fields[$index]['options']):0;
           $this->fields[$index]['options'][$subIndex] =
               '<tr>
             <td>'.($subIndex+1).'</td>
             <td>
             <div>
             <label for="label" class="form-label"></label>
             <input type="text" class="form-control " id="label" name="form.option.label" wire:model="form.'.$index.'.option.'.$subIndex.'.label" value="" placeholder="" aria-describedby="label-helper">
             </div>
             </td>
             <td>
             <div>
             <label for="value" class="form-label"></label>
             <input type="text" class="form-control " id="value" name="form.option.value" wire:model="form.'.$index.'.option.'.$subIndex.'.value" value="" placeholder="" aria-describedby="value-helper">
             </div>
             </td>
             <td>
             <button class="btn btn-sm btn-outline-danger" type="button" wire:click="removeOption('.$index.','.$subIndex.')"><i class="bx bx-trash-alt" ></i></button>
             </td>
             </tr>';
       }
    }

    public function removeOption($index,$subIndex,$nestedIndex = null)
    {
        if(isset($nestedIndex)){
            unset($this->fields[$index]['fields'][$nestedIndex]['options'][$subIndex]);

        }else{
            unset($this->fields[$index]['options'][$subIndex]);
        }
    }
    private function generateFieldHtml($type,$index = 0)
    {
        switch ($type) {
            case 'text':
                return '<div class="row mt-2">
                         <div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <label for="">Select Input Type</label>
                         <select
                         name="input_type"
                         id=""
                         wire:change="onTextSelect('.str_replace('.',',',$index).')"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.input_type">
                         <option value="text">Select any one </option>
                         <option value="text">Text</option>
                         <option value="email">Email</option>
                         <option value="number">Number</option>
                         <option value="tel">Tel</option>
                         <option value="url">URL</option>
                         </select>
                         </div>
                         <div class="col-md-3">
                         <label for="">Label</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.label"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Slug">Slug</label>
                         <input type="text" required
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.slug"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Default Value">Default Value</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.default_value"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Placeholder</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.placeholder"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Helper Text</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.helper_text"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Max Length</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.max_length"
                         >
                         </div>
                         <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'email':
                return '<div class="row mt-2">
                         <div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <label for="">Select Input Type</label>
                         <select
                         name="input_type"
                         id=""
                         wire:change="onTextSelect('.str_replace('.',',',$index).')"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.input_type">
                         <option value="text">Text</option>
                         <option value="email">Email</option>
                         <option value="number">Number</option>
                         <option value="tel">Tel</option>
                         <option value="url">URL</option>
                         </select>
                         </div>
                         <div class="col-md-3">
                         <label for="">Label</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.label"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Slug">Slug</label>
                         <input type="text" required
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.slug"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="Default Value">Default Value</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.default_value"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Placeholder</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.placeholder"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Helper Text</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.helper_text"
                         >
                         </div>
                         <div class="col-md-3">
                         <label for="">Max Length</label>
                         <input type="text"
                         class="form-control form-control-sm"
                         wire:model="form.'.$index.'.max_length"
                         >
                         </div>
                         <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required'.$index.'" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                          <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                         <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                          <div class="col-md-3">
                        <label for="">Does this field have multiple value?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_multiple" name="is_multiple" value="yes" class="form-check-input" id="mulitipled_yes_{{ $index }}">
                        <label class="form-check-label" for="mulitipled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_multiple" name="is_multiple" value="no" class="form-check-input" id="multipled_no_{{ $index }}">
                        <label class="form-check-label" for="multipled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                         </div>
                         </div>
                         </div>';
            case 'number':
                return '<div class="row mt-2">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                        <label for="">Input Type</label>
                        <select
                        name="input_type"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.input_type"
                        wire:change="onTextSelect('.str_replace('.',',',$index).')">
                        <option value="text">Text</option>
                        <option value="number" selected>Number</option>
                        <option value="tel">Tel</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label for="">Label</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.label">
                        </div>
                        <div class="col-md-3">
                        <label for="Slug">Slug</label>
                        <input type="text" required
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.slug">
                        </div>
                        <div class="col-md-3">
                        <label for="Default Value">Default Value</label>
                        <input type="number"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.default_value">
                        </div>
                        <div class="col-md-3">
                        <label for="">Placeholder</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.placeholder">
                        </div>
                        <div class="col-md-3">
                        <label for="">Helper Text</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.helper_text">
                        </div>
                        <div class="col-md-3">
                        <label for="">Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Max-Length</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.max">
                        </div>
                        <div class="col-md-3">
                        <label for="">Min</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.min">
                        </div>
                        <div class="col-md-3">
                        <label for="">Steps</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.steps">
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'tel':
                return '<div class="row mt-2">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                        <label for="">Input Type</label>
                        <select
                        name="input_type"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.input_type"
                        wire:change="onTextSelect('.str_replace('.',',',$index).')">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="tel" selected>Tel</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label for="">Label</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.label">
                        </div>
                        <div class="col-md-3">
                        <label for="Slug">Slug</label>
                        <input type="text" required
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.slug">
                        </div>
                        <div class="col-md-3">
                        <label for="Default Value">Default Value</label>
                        <input type="number"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.default_value">
                        </div>
                        <div class="col-md-3">
                        <label for="">Placeholder</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.placeholder">
                        </div>
                        <div class="col-md-3">
                        <label for="">Helper Text</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.helper_text">
                        </div>
                        <div class="col-md-3">
                        <label for="">Max-Length</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.max-length">
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required_'.$index.'" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required_'.$index.'" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly'.$index.'"" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'"" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled'.$index.'"" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'url':
                return '<div class="row mt-2">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3">
                        <label for="">Input Type</label>
                        <select
                        name="input_type"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.input_type"
                        wire:change="onTextSelect('.str_replace('.',',',$index).')">
                        <option value="text">Text</option>
                        <option value="number" >Number</option>
                        <option value="tel">Tel</option>
                        <option value="email">Email</option>
                        <option value="url" selected >URL</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label for="">Label</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.label">
                        </div>
                        <div class="col-md-3">
                        <label for="Slug">Slug</label>
                        <input type="text" required
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.slug">
                        </div>
                        <div class="col-md-3">
                        <label for="Default Value">Default Value</label>
                        <input type="number"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.default_value">
                        </div>
                        <div class="col-md-3">
                        <label for="">Placeholder</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.placeholder">
                        </div>
                        <div class="col-md-3">
                        <label for="">Helper Text</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.helper_text">
                        </div>
                        <div class="col-md-3">
                        <label for="">Max-Length</label>
                        <input type="text"
                        class="form-control form-control-sm"
                        wire:model="form.'.$index.'.max-length">
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Required?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="yes" class="form-check-input" id="required_yes_{{ $index }}">
                        <label class="form-check-label" for="required_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_required" name="is_required" value="no" class="form-check-input" id="required_no_{{ $index }}">
                        <label class="form-check-label" for="required_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <label for="">Is This Field Read Only?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="yes" class="form-check-input" id="readonly_yes_{{ $index }}">
                        <label class="form-check-label" for="readonly_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_readonly" name="is_readonly" value="no" class="form-check-input" id="readonly_no_{{ $index }}">
                        <label class="form-check-label" for="readonly_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>

                        <div class="col-md-3">
                        <label for="">Is This Field Disabled?</label>
                        <div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="yes" class="form-check-input" id="disabled_yes_{{ $index }}">
                        <label class="form-check-label" for="disabled_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check">
                        <input type="radio" wire:model="form.'.$index.'.is_disabled" name="is_disabled" value="no" class="form-check-input" id="disabled_no_{{ $index }}">
                        <label class="form-check-label" for="disabled_no_{{ $index }}">No</label>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>';
            case 'select':
                return '<div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <div>
                         <label for="label" class="form-label">Label</label>
                         <input type="text" class="form-control " id="label" name="form.label" wire:model="form.'.$index.'.label" value="" placeholder="" aria-describedby="label-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="slug" class="form-label">Slug</label>
                         <input type="text" class="form-control " required id="slug" name="form.slug" wire:model="form.'.$index.'.slug" value="" placeholder="" aria-describedby="slug-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="default_value" class="form-label">Default Value</label>
                         <input type="text" class="form-control " id="default_value" name="form.default_value" wire:model="form.'.$index.'.default_value" value="" placeholder="" aria-describedby="default_value-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="helper_text" class="form-label">Helper Text</label>
                         <input type="text" class="form-control " id="helper_text" name="form.helper_text" wire:model="form.'.$index.'.helper_text" value="" placeholder="" aria-describedby="helper_text-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field Required?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-1" name="form.'.$index.'.is_required" value="yes" class="form-check-input ">
                         <label for="is_required-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-0" name="form.'.$index.'.is_required" value="no" class="form-check-input " checked="">
                         <label for="is_required-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field read only?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-1" name="form.'.$index.'is_readonly" value="yes" class="form-check-input ">
                         <label for="is_readonly-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-0" name="form'.$index.'is_readonly" value="no" class="form-check-input " checked="">
                         <label for="is_readonly-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field disabled?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-1" name="form'.$index.'is_disabled" value="yes" class="form-check-input ">
                         <label for="is_disabled-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-0" name="form'.$index.'is_disabled" value="no" class="form-check-input " checked="">
                         <label for="is_disabled-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Does this field have multiple value?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-1" name="form'.$index.'is_multiple" value="yes" class="form-check-input ">
                         <label for="is_multiple-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-0" name="form'.$index.'is_multiple" value="no" class="form-check-input " checked="">
                         <label for="is_multiple-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         </div>
                         <br>
                         <h5>Option List</h5>
                         <table class="table table-striped">
                         <thead>
                         <tr>
                         <th>SNo</th>
                         <th>Label</th>
                         <th>Value</th>
                         <th>
                         <button class="btn btn-sm btn-outline-primary" type="button" wire:click="addOptionListItem('.str_replace('.',',',$index).')">Add Option</button>
                         </th>
                         </tr>
                         </thead>
                         <tbody>
                                <p> </p>
                         </tbody>
                         </table>
                         </div>';
            case 'checkbox':
                return '<div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <div>
                         <label for="label" class="form-label">Label</label>
                         <input type="text" class="form-control " id="label" name="form.label" wire:model="form.'.$index.'.label" value="" placeholder="" aria-describedby="label-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="slug" class="form-label">Slug</label>
                         <input type="text" class="form-control " required id="slug" name="form.slug" wire:model="form.'.$index.'.slug" value="" placeholder="" aria-describedby="slug-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="default_value" class="form-label">Default Value</label>
                         <input type="text" class="form-control " id="default_value" name="form.default_value" wire:model="form.'.$index.'.default_value" value="" placeholder="" aria-describedby="default_value-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="helper_text" class="form-label">Helper Text</label>
                         <input type="text" class="form-control " id="helper_text" name="form.helper_text" wire:model="form.'.$index.'.helper_text" value="" placeholder="" aria-describedby="helper_text-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field Required?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-1" name="form.'.$index.'.checkbox.is_required" value="yes" class="form-check-input ">
                         <label for="is_required-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-0" name="form.'.$index.'.checkbox.is_required" value="no" class="form-check-input " checked="">
                         <label for="is_required-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field read only?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-1" name="form'.$index.'checkbox.is_readonly" value="yes" class="form-check-input ">
                         <label for="is_readonly-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-0" name="form'.$index.'checkbox.is_readonly" value="no" class="form-check-input " checked="">
                         <label for="is_readonly-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field disabled?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-1" name="form'.$index.'checkbox.is_disabled" value="yes" class="form-check-input ">
                         <label for="is_disabled-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-0" name="form'.$index.'checkbox.is_disabled" value="no" class="form-check-input " checked="">
                         <label for="is_disabled-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Does this field have multiple value?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-1" name="form'.$index.'checkbox.is_multiple" value="yes" class="form-check-input ">
                         <label for="is_multiple-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-0" name="form'.$index.'checkbox.is_multiple" value="no" class="form-check-input " checked="">
                         <label for="is_multiple-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         </div>
                         <br>
                         <h5>Option List</h5>
                         <table class="table table-striped">
                         <thead>
                         <tr>
                         <th>SNo</th>
                         <th>Label</th>
                         <th>Value</th>
                         <th>
                         <button class="btn btn-sm btn-outline-primary" type="button" wire:click="addOptionListItem('.str_replace('.',',',$index).')">Add Option</button>
                         </th>
                         </tr>
                         </thead>
                         <tbody>
                                 <p> </p>
                         </tbody>
                         </table>
                         </div>';
            case 'radio':
                return '<div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <div>
                         <label for="label" class="form-label">Label</label>
                         <input type="text" class="form-control " id="label" name="form.label" wire:model="form.'.$index.'.label" value="" placeholder="" aria-describedby="label-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="slug" class="form-label">Slug</label>
                         <input type="text" class="form-control " required id="slug" name="form.slug" wire:model="form.'.$index.'.slug" value="" placeholder="" aria-describedby="slug-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="default_value" class="form-label">Default Value</label>
                         <input type="text" class="form-control " id="default_value" name="form.default_value" wire:model="form.'.$index.'.default_value" value="" placeholder="" aria-describedby="default_value-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="helper_text" class="form-label">Helper Text</label>
                         <input type="text" class="form-control " id="helper_text" name="form.helper_text" wire:model="form.'.$index.'.helper_text" value="" placeholder="" aria-describedby="helper_text-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field Required?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-1" name="form.'.$index.'.radio.is_required" value="yes" class="form-check-input ">
                         <label for="is_required-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-0" name="form.'.$index.'.radio.is_required" value="no" class="form-check-input " checked="">
                         <label for="is_required-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field read only?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-1" name="form'.$index.'radio.is_readonly" value="yes" class="form-check-input ">
                         <label for="is_readonly-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-0" name="form'.$index.'radio.is_readonly" value="no" class="form-check-input " checked="">
                         <label for="is_readonly-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field disabled?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-1" name="form'.$index.'radio.is_disabled" value="yes" class="form-check-input ">
                         <label for="is_disabled-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-0" name="form'.$index.'radio.is_disabled" value="no" class="form-check-input " checked="">
                         <label for="is_disabled-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Does this field have multiple value?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-1" name="form'.$index.'radio.is_multiple" value="yes" class="form-check-input ">
                         <label for="is_multiple-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-0" name="form'.$index.'radio.is_multiple" value="no" class="form-check-input " checked="">
                         <label for="is_multiple-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         </div>
                         <br>
                         <h5>Option List</h5>
                         <table class="table table-striped">
                         <thead>
                         <tr>
                         <th>SNo</th>
                         <th>Label</th>
                         <th>Value</th>
                         <th>
                         <button class="btn btn-sm btn-outline-primary" type="button" wire:click="addOptionListItem('.str_replace('.',',',$index).')">Add Option</button>
                         </th>
                         </tr>
                         </thead>
                         <tbody>
                               <p> </p>
                         </tbody>
                         </table>
                         </div>';
            case 'file':
                return '
           <div class="col-md-12 ">
                         <div class="row">
                         <div class="col-md-3">
                         <div>
                         <label for="label" class="form-label">Label</label>
                         <input type="text" class="form-control " id="label" name="form.label" wire:model="form.'.$index.'.label" value="" placeholder="" aria-describedby="label-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="slug" class="form-label">Slug</label>
                         <input type="text" class="form-control " required id="slug" name="form.slug" wire:model="form.'.$index.'.slug" value="" placeholder="" aria-describedby="slug-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="default_value" class="form-label">Default Value</label>
                         <input type="text" class="form-control " id="default_value" name="form.default_value" wire:model="form.'.$index.'.default_value" value="" placeholder="" aria-describedby="default_value-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="helper_text" class="form-label">Helper Text</label>
                         <input type="text" class="form-control " id="helper_text" name="form.helper_text" wire:model="form.'.$index.'.helper_text" value="" placeholder="" aria-describedby="helper_text-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field Required?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-1" name="form.'.$index.'.is_required" value="yes" class="form-check-input ">
                         <label for="is_required-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_required" id="is_required-0" name="form.'.$index.'.is_required" value="no" class="form-check-input " checked="">
                         <label for="is_required-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field read only?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-1" name="form'.$index.'is_readonly" value="yes" class="form-check-input ">
                         <label for="is_readonly-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_readonly" id="is_readonly-0" name="form'.$index.'is_readonly" value="no" class="form-check-input " checked="">
                         <label for="is_readonly-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Is this field disabled?</p>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-1" name="form'.$index.'is_disabled" value="yes" class="form-check-input ">
                         <label for="is_disabled-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_disabled" id="is_disabled-0" name="form'.$index.'is_disabled" value="no" class="form-check-input " checked="">
                         <label for="is_disabled-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <p class="form-label">Does this field have multiple value?</p>
                          <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-1" name="form'.$index.'is_multiple" value="yes" class="form-check-input ">
                         <label for="is_multiple-1" class="form-check-label">Yes</label>
                         </div>
                         <div class="form-check">
                         <input type="radio" wire:model="form.'.$index.'.is_multiple" id="is_multiple-0" name="form'.$index.'is_multiple" value="no" class="form-check-input " checked="">
                         <label for="is_multiple-0" class="form-check-label">No</label>
                         </div>
                         </div>
                         </div>
                         </div>
                         </div>
            <div>
            </div>';
            case 'table':
                return '<div>
                         <div class="row">
                         <div class="col-md-3">
                         <div>
                         <label for="label" class="form-label">Label</label>
                         <input type="text" class="form-control " id="label" name="form.label" wire:model="form.'.$index.'.label" value="" placeholder="" aria-describedby="label-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="slug" class="form-label">Slug</label>
                         <input type="text" class="form-control " required id="slug" name="form.slug" wire:model="form.'.$index.'.slug" value="" placeholder="" aria-describedby="slug-helper">
                         </div>
                         </div>

                         </div>
                         <div class="p-4 border mt-2 border-2 border-primary rounded">

                         <p> </p>
                         </div>
                         <div class="mt-2 d-flex justify-content-end">
                         <button type="button"
                         class="btn btn-primary "
                         wire:click="addTableField('.$index.')">
                            पङ्क्ति थप्नुहोस्
                         </button>
                         </div>
                        </div>
                         <div>
                         </div>';
            case 'group':
                return '<div class="border-1 rounded p-4">
                         <div class="row">
                         <div class="col-md-3">
                         <div>
                         <label for="label" class="form-label">Label</label>
                         <input type="text" class="form-control " id="label" name="form.label" wire:model="form.'.$index.'.label" value="" placeholder="" aria-describedby="label-helper">
                         </div>
                         </div>
                         <div class="col-md-3">
                         <div>
                         <label for="slug" class="form-label">Slug</label>
                         <input type="text" class="form-control " required id="slug" name="form.slug" wire:model="form.'.$index.'.slug" value="" placeholder="" aria-describedby="slug-helper">
                         </div>
                         </div>

                         </div>
                         <div class="p-4 border mt-2 border-2 border-primary rounded">

                         <p> </p>
                         </div>
                         <div class="mt-2 d-flex justify-content-end">
                         <button type="button"
                         class="btn btn-primary "
                         wire:click="addGroupField('.$index.')">
                            पङ्क्ति थप्नुहोस्
                         </button>
                         </div>
                        </div>
                         <div>
                         </div>';
            default:
                return '';
        }
    }
    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
        unset($this->form[$index]);
    }
    public function save()
    {
        $validatedData = $this->validate();

        $title = $validatedData['form']['title'];
        $module = $validatedData['form']['module'];
        $formFiltered = array_filter($this->form, function($key) {
            return !in_array($key, ['id', 'title', 'module']);
        }, ARRAY_FILTER_USE_KEY);

        try{
            $dto = FormAdminDto::fromLiveWireModel([
                'title' => $title,
                'module' => $module,
                'fields' => $formFiltered
            ]);
        
            $service = new FormAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    break;
                case Action::UPDATE:
                    $id = $validatedData['form']['id'];
                    $service->update($this->form, $dto, $id);
                    break;
            }
            foreach ($this->modules as $key => $module) {
                if (str_contains(strtolower($this->path), strtolower($module))) {
                
                    $moduleName = Str::before(Str::after($this->path, 'admin/'), '/');
                
                    return redirect()->route( 'admin.'. $moduleName . '.form-template.index');
                    break;
                }
            }
            return redirect()->route('admin.setting.form.index');
    //        return redirect()->route('admin.setting.form.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

}
