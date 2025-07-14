<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\TaskTracking\Controllers\AnusuchiAdminController;
use Src\TaskTracking\DTO\AnusuchiAdminDto;
use Src\TaskTracking\DTO\CriterionAdminDto;
use Src\TaskTracking\Models\Anusuchi;
use Src\TaskTracking\Service\AnusuchiAdminService;
use Src\TaskTracking\Models\Criterion;
use Src\TaskTracking\Service\CriterionAdminService;

class AnusuchiForm extends Component
{
    use SessionFlash;

    public ?Anusuchi $anusuchi;
    public ?Action $action;
    public  array $criterion;

    public function rules(): array
    {
        return [
    'anusuchi.name' => ['required'],
    'anusuchi.name_en' => ['required'],
    'anusuchi.description' => ['required'],
            'criterion.*.name' => ['required'],
            'criterion.*.name_en' => ['required'],
            'criterion.*.max_score' => ['required'],
            'criterion.*.min_score' => ['required'],
            ];
    }
    public function messages(): array
    {
        return [
            'anusuchi.name.required' => __('tasktracking::tasktracking.name_is_required'),
            'anusuchi.name_en.required' => __('tasktracking::tasktracking.name_en_is_required'),
            'anusuchi.description.required' => __('tasktracking::tasktracking.description_is_required'),
            'criterion.*.name.required' => __('tasktracking::tasktracking.name_is_required'),
            'criterion.*.name_en.required' => __('tasktracking::tasktracking.name_en_is_required'),
            'criterion.*.max_score.required' => __('tasktracking::tasktracking.max_score_is_required'),
            'criterion.*.min_score.required' => __('tasktracking::tasktracking.min_score_is_required'),
        ];
    }


    public function render(){
        return view("TaskTracking::livewire.anusuchi-form");
    }

    public function mount(Anusuchi $anusuchi,Action $action)
    {
        $this->anusuchi = $anusuchi->load('criterion');
        $this->action = $action;

        if ($this->action === Action::UPDATE) {
            // dd($this->anusuchi);

            foreach ($this->anusuchi->criterion as $item) {

                $this->criterion[] = [
                    'anusuchi_id' => $item->anusuchi_id,
                    'name' => $item->name,
                    'name_en' => $item->name_en,
                    'max_score' => $item->max_score,
                    'min_score' => $item->min_score,
                ];
            }
        }
    }
    public function addCriteria()
    {
        $this->criterion []= [
            'anusuchi_id'=>$this->anusuchi?->id ?? 0,
            'name'=>'',
            'name_en'=>'',
            'max_score'=>0,
            'min_score'=>0,
        ];
    }

    public function removeCriterion($key)
    {
        unset($this->criterion[$key]);
        $key = array_values($this->criterion);
    }
    public function save()
    {
        $this->validate();

        DB::beginTransaction();
        try{
            $dto = AnusuchiAdminDto::fromLiveWireModel($this->anusuchi);
            $service = new AnusuchiAdminService();
            $criterionService = new CriterionAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $anusuchi = $service->store($dto);

                    foreach ($this->criterion as $criteria) {
                        $criteria['anusuchi_id'] = $anusuchi->id;
                        $criteriaDto = CriterionAdminDto::fromArray($criteria);
                        $criterionService->store($criteriaDto);
                    }
                    DB::commit();
                    $this->successFlash(__('tasktracking::tasktracking.anusuchi_created_successfully'));
                    return redirect()->route('admin.anusuchis.index');

                case Action::UPDATE:
                    $service->update($this->anusuchi, $dto);
                    Criterion::where('anusuchi_id', $this->anusuchi->id)->delete();

                    foreach ($this->criterion as $criteria) {
                        $criteria['anusuchi_id'] = $this->anusuchi->id;
                        $criteriaDto = CriterionAdminDto::fromArray($criteria);
                        $criterionService->store($criteriaDto);
                    }
                    DB::commit();
                    $this->successFlash(__('tasktracking::tasktracking.anusuchi_updated_successfully'));
                    return redirect()->route('admin.anusuchis.index');

                default:
                    return redirect()->route('admin.anusuchis.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            DB::rollBack();
            $this->errorFlash(((__('tasktracking::tasktracking.something_went_wrong_while_saving') . $e->getMessage())));
        }
    }

}
