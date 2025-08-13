<?php

namespace Src\Ebps\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Ebps\DTO\MapApplyStepApproverAdminDto;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\FormSubmitterEnum;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapApplyStepTemplate;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Service\MapApplyStepApproverAdminService;

class MapAppliesApproveAllSteps extends Component
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
        return view('Ebps::livewire.map-applies-approve-all-steps');
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
            // Get the first 3 map applies steps
            $mapSteps = MapStep::whereNull('deleted_by')
                ->where('application_type', ApplicationTypeEnum::MAP_APPLIES)
                ->orderBy('id')
                ->take(3)
                ->get();

            $approvedCount = 0;

            foreach ($mapSteps as $mapStep) {
                // Find or create MapApplyStep for this step
                $mapApplyStep = MapApplyStep::where('map_step_id', $mapStep->id)
                    ->where('map_apply_id', $this->mapApply->id)
                    ->first();

                // Only process if the step is not already accepted
                if (!$mapApplyStep || $mapApplyStep->status !== 'accepted') {
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
                        reason: 'Approved via bulk approval for map applies',
                    );

                    $service = new MapApplyStepApproverAdminService();
                    $service->store($dto);

                    $approvedCount++;
                }
            }

            $this->successFlash(__('ebps::ebps.map_applies_steps_approved_successfully', ['count' => $approvedCount]));
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
        // Get the first 3 map applies steps
        $mapSteps = MapStep::whereNull('deleted_by')
            ->where('application_type', ApplicationTypeEnum::MAP_APPLIES)
            ->orderBy('id')
            ->take(3)
            ->get();

        // If there are fewer than 3 steps, don't show the button
        if ($mapSteps->count() < 3) {
            return false;
        }

        // Check if all 3 steps are pending (not accepted) and have consultant_supervisor as submitter
        $pendingCount = 0;
        $consultantSupervisorCount = 0;
        
        foreach ($mapSteps as $mapStep) {
            // Use the same logic as the view to determine status
            $appliedStep = $this->mapApply->mapApplySteps->where('map_step_id', $mapStep->id)->first();
            $status = $appliedStep ? $appliedStep->status : 'not_applied';

            if ($appliedStep && $appliedStep->status === 'pending') {
                $pendingCount++;
            }
            
            // Check if submitter is consultant_supervisor
            if (strtolower($mapStep->form_submitter) === FormSubmitterEnum::CONSULTANT_SUPERVISOR->value) {
                $consultantSupervisorCount++;
            }
        }
        

        // Only show button if exactly 3 steps are pending AND all 3 have consultant_supervisor as submitter
        return $pendingCount === 3 && $consultantSupervisorCount === 3;
    }
} 