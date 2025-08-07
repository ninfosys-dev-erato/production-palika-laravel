<?php

namespace Src\Ebps\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Ebps\DTO\MapApplyStepApproverAdminDto;
use Src\Ebps\Enums\FormPositionEnum;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\MapApplyStepApproverAdminService;

class ApproveAllSteps extends Component
{
    use SessionFlash;

    public MapApply $mapApply;
    public bool $showConfirmationModal = false;

    public function mount(MapApply $mapApply)
    {
        $this->mapApply = $mapApply;
    }

    public function render()
    {
        return view('Ebps::livewire.approve-all-steps');
    }

    public function showConfirmation()
    {
        $this->showConfirmationModal = true;
    }

    public function hideConfirmation()
    {
        $this->showConfirmationModal = false;
    }

    public function approveAllSteps()
    {
        try {
            // Get all before steps that are not already accepted
            $beforeSteps = MapStep::whereNull('deleted_by')
                ->where('form_position', FormPositionEnum::BEFORE_FILLING_APPLICATION)
                ->get();

            $approvedCount = 0;

            foreach ($beforeSteps as $mapStep) {
                // Find or create MapApplyStep for this step
                $mapApplyStep = MapApplyStep::where('map_step_id', $mapStep->id)
                    ->where('map_apply_id', $this->mapApply->id)
                    ->first();

                if (!$mapApplyStep) {
                    // Create new MapApplyStep if it doesn't exist
                    $mapApplyStep = MapApplyStep::create([
                        'map_apply_id' => $this->mapApply->id,
                        'form_id' => $mapStep->form_id,
                        'map_step_id' => $mapStep->id,
                        'status' => 'accepted',
                        'reviewed_by' => Auth::user()->id,
                    ]);
                } else {
                    // Update existing MapApplyStep
                    $mapApplyStep->update([
                        'status' => 'accepted',
                        'reviewed_by' => Auth::user()->id,
                    ]);
                }

                // Update templates with signature if they exist
                foreach ($mapApplyStep->mapApplyStepTemplates as $template) {
                    $signature = Auth::user()?->signature
                        ? '<img src="data:image/jpeg;base64,' . Auth::user()->signature . '" alt="Signature" width="80">'
                        : 'No Signature Available';
                    
                    $updatedTemplate = Str::replace('{{form.approver.signature}}', $signature, $template->template);
                    
                    $template->update([
                        'template' => $updatedTemplate,
                    ]);
                }

                // Create approval record
                $dto = MapApplyStepApproverAdminDto::fromStepAndUser(
                    mapApplyStepId: $mapApplyStep->id,
                    userId: Auth::user()->id,
                    status: 'accepted',
                    reason: 'Approved via bulk approval',
                );

                $service = new MapApplyStepApproverAdminService();
                $service->store($dto);

                $approvedCount++;
            }

            $this->successFlash(__('ebps::ebps.all_steps_approved_successfully', ['count' => $approvedCount]));
            $this->hideConfirmation();
            
            // Redirect to refresh the page
            return redirect()->route('admin.ebps.map_applies.step', $this->mapApply->id);

        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash(__('ebps::ebps.something_went_wrong_while_approving_steps') . ': ' . $e->getMessage());
            $this->hideConfirmation();
        }
    }

    public function canApproveAllSteps()
    {
        // Check if there are any before steps that are not accepted
        $beforeSteps = MapStep::whereNull('deleted_by')
            ->where('form_position', FormPositionEnum::BEFORE_FILLING_APPLICATION)
            ->get();

        foreach ($beforeSteps as $mapStep) {
            $mapApplyStep = MapApplyStep::where('map_step_id', $mapStep->id)
                ->where('map_apply_id', $this->mapApply->id)
                ->first();

            if (!$mapApplyStep || $mapApplyStep->status !== 'accepted') {
                return true; // Can approve if any step is not accepted
            }
        }

        return false; // All steps are already accepted
    }
} 