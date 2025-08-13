<?php

namespace Src\Beruju\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Beruju\DTO\SubCategoryAdminDto;
use Src\Beruju\Models\SubCategory;
use Src\Beruju\Service\SubCategoryAdminService;
use Livewire\Attributes\On;

class SubCategoryForm extends Component
{
    use SessionFlash;

    public ?SubCategory $subCategory;
    public ?Action $action = Action::CREATE;
    public $parentCategories;

    public function rules(): array
    {
        return [
            'subCategory.name' => ['required'],
            'subCategory.slug' => ['required'],
            'subCategory.parent_id' => ['nullable'],
            'subCategory.remarks' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'subCategory.name.required' => __('beruju::beruju.name_required'),
            'subCategory.slug.required' => __('beruju::beruju.slug_required'),
            'subCategory.parent_id.nullable' => __('beruju::beruju.parent_id_exists'),
            'subCategory.remarks.nullable' => __('beruju::beruju.no_remarks'),
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.sub-category-form");
    }

    public function mount(SubCategory $subCategory = null, Action $action = Action::CREATE)
    {
        $this->subCategory = $subCategory ?? new SubCategory();
        $this->action = $action;
        $this->parentCategories = SubCategory::whereNull('deleted_at')->pluck('name', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = SubCategoryAdminDto::fromLiveWireModel($this->subCategory);
        $service = new SubCategoryAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('beruju::beruju.sub_category_created'));
                $this->dispatch('close-modal');
                break;
            case Action::UPDATE:
                $service->update($this->subCategory, $dto);
                $this->successFlash(__('beruju::beruju.sub_category_updated'));
                $this->dispatch('close-modal');
                break;
            default:
                return redirect()->route('admin.beruju.sub-categories.index');
                break;
        }
    }

    #[On('edit-sub-category')]
    public function subCategory(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetSubCategory()
    {
        $this->reset(['subCategory', 'action']);
        $this->subCategory = new SubCategory();
    }
}
