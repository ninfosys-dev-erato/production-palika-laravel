<?php

namespace Src\Grievance\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Grievance\Models\GrievanceDetail;

class GrievanceDetailChangeVisibilityStatusForm extends Component
{
    use SessionFlash;

    public ?GrievanceDetail $grievanceDetail;
    public Action $action;
    public $users = [];

    public function rules(): array
    {
        return [
            'grievanceDetail.is_visible_to_public' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'grievanceDetail.is_visible_to_public.required' => __('grievance::grievance.is_visible_to_public_is_required'),
        ];
    }

    public function render()
    {
        return view("Grievance::livewire.grievanceDetail.changeVisibilityStatus");
    }

    
    public function mount(GrievanceDetail $grievanceDetail): void
    {
        $this->grievanceDetail = $grievanceDetail;
    }

    public function save()
    {
        $this->grievanceDetail->is_visible_to_public = !$this->grievanceDetail->is_visible_to_public;
        $this->grievanceDetail->save();
        return redirect()->route('admin.grievance.grievanceDetail.show', $this->grievanceDetail->id);
    }
}