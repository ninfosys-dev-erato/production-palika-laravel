<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\MediatorSelectionAdminDto;
use Src\Ejalas\Enum\MediatorSelectionType;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\Mediator;
use Src\Ejalas\Models\MediatorSelection;
use Src\Ejalas\Service\MediatorSelectionAdminService;

class MediatorSelectionForm extends Component
{
    use SessionFlash;

    public ?MediatorSelection $mediatorSelection;
    public ?Action $action;
    public $complainRegistrations;
    public $mediators;
    public $mediatorSelectionTypes;
    public $from;

    public function rules(): array
    {
        return [
            'mediatorSelection.complaint_registration_id' => ['required'],
            'mediatorSelection.mediator_id' => ['required'],
            'mediatorSelection.mediator_type' => ['required'],
            'mediatorSelection.selection_date' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.mediator-selection.form");
    }

    public function mount(MediatorSelection $mediatorSelection, Action $action, $from)
    {
        $this->mediatorSelection = $mediatorSelection;
        $this->action = $action;
        $this->from = $from;

        $complaintIdToKeep = $this->mediatorSelection->complaint_registration_id ?? null; //when on update

        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')
            ->where('status', true)
            ->where(function ($query) use ($complaintIdToKeep) {
                $query->whereNotIn('id', function ($subquery) {
                    $subquery->select('complaint_registration_id')
                        ->from('jms_mediator_selections')
                        ->whereNull('deleted_at');
                });
                if ($complaintIdToKeep) { //when on update include it's complaint registration id
                    $query->orWhere('id', $complaintIdToKeep);
                }
            })
            ->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        $this->mediators = Mediator::whereNull('deleted_at')->pluck('mediator_name', 'id');
        $this->mediatorSelectionTypes = MediatorSelectionType::getForWeb();
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = MediatorSelectionAdminDto::fromLiveWireModel($this->mediatorSelection);
            $service = new MediatorSelectionAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.mediator_selection_created_successfully'));
                    return redirect()->route('admin.ejalas.mediator_selections.index', ['from' => $this->from]);
                    break;
                case Action::UPDATE:
                    $service->update($this->mediatorSelection, $dto);
                    $this->successFlash(__('ejalas::ejalas.mediator_selection_updated_successfully'));
                    return redirect()->route('admin.ejalas.mediator_selections.index', ['from' => $this->from]);
                    break;
                default:
                    return redirect()->route('admin.ejalas.mediator_selections.index', ['from' => $this->from]);
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
