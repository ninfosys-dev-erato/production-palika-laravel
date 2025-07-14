<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Src\Yojana\Controllers\PlanExtensionRecordAdminController;
use Src\Yojana\DTO\PlanExtensionRecordAdminDto;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanExtensionRecord;
use Src\Yojana\Models\ProjectDocument;
use Src\Yojana\Service\PlanExtensionRecordAdminService;

class PlanExtensionRecordForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?PlanExtensionRecord $planExtensionRecord;
    public ?Action $action = Action::CREATE;
    public $plan;

    protected $listeners = ['load-plan-extension' => 'loadPlanExtension'];
    public function rules(): array
    {
        return [
    'planExtensionRecord.plan_id' => ['required'],
    'planExtensionRecord.extension_date' => ['required'],
    'planExtensionRecord.previous_extension_date' => ['nullable'],
    'planExtensionRecord.previous_completion_date' => ['nullable'],
    'planExtensionRecord.letter_submission_date' => ['required'],
    'planExtensionRecord.letter' => ['nullable'],
];
    }

    public function render(){
        return view("Yojana::livewire.plan-extension-records-form");
    }

    public function mount(PlanExtensionRecord $planExtensionRecord, Plan $plan)
    {
        $this->planExtensionRecord = $planExtensionRecord;
        $this->planExtensionRecord->plan_id = $plan->id;
        $this->action = Action::CREATE;
        $this->plan = $plan;
    }

    public function loadPlanExtension($id)
    {
        $this->planExtensionRecord = PlanExtensionRecord::whereNull('deleted_at')->find($id);
        $this->action = Action::UPDATE;
    }

    public function resetPlanExtension()
    {
        $this->planExtensionRecord = new PlanExtensionRecord();
        $this->planExtensionRecord->plan_id = $this->plan->id;
        $this->action = Action::CREATE;
    }

    public function save()
    {
        $this->validate();
        try{
            if($this->planExtensionRecord->letter instanceof  TemporaryUploadedFile){
                $this->planExtensionRecord->letter =  FileFacade::saveFile(
                    path: config('src.Yojana.yojana.evaluation'),
                    file: $this->planExtensionRecord->letter,
                    disk: "local",
                    filename: ""
                );
            }
            $previousExtensionRecord = PlanExtensionRecord::where('plan_id', $this->plan->id)
                ->latest()
                ->first();
            $dto = PlanExtensionRecordAdminDto::fromPlanModel(
                plan: $this->plan,
                extend_to: $this->planExtensionRecord->extension_date,
                letter_extension_date: $this->planExtensionRecord->letter_submission_date,
                previous_extension_record: $previousExtensionRecord
            );
            $dto->letter = $this->planExtensionRecord->letter;
            $service = new PlanExtensionRecordAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $created = $service->store($dto);
                    if ($created instanceof PlanExtensionRecord) {
                        $this->successFlash(__('yojana::yojana.plan_extension_record_created_successfully'));
                        $this->resetPlanExtension();
                    } else {
                        $this->errorFlash(__('yojana::yojana.plan_extension_record_failed_to_create'));
                    }
                    break;
                case Action::UPDATE:
                    $service->update($this->planExtensionRecord, $dto);
                    $this->successFlash(__('yojana::yojana.plan_extension_record_updated_successfully'));
                    $this->resetPlanExtension();
                    break;
                default:
                    break;
            }
        }catch (\Exception $exception){
            DB::rollBack();
//                        dd($e->getMessage());
            $this->errorFlash(collect($exception)->flatten()->first());
        }

    }

}
