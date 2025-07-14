<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\WitnessesRepresentativeAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\WitnessesRepresentative;
use Src\Ejalas\Service\WitnessesRepresentativeAdminService;

class WitnessesRepresentativeForm extends Component
{
    use SessionFlash;

    public ?WitnessesRepresentative $witnessesRepresentative;
    public ?Action $action;
    public $complainRegistrations;

    public function rules(): array
    {
        return [
            'witnessesRepresentative.complaint_registration_id' => ['required'],
            'witnessesRepresentative.name' => ['required'],
            'witnessesRepresentative.address' => ['required'],
            'witnessesRepresentative.is_first_party' => ['nullable'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.witness-representative.form");
    }

    public function mount(WitnessesRepresentative $witnessesRepresentative, Action $action)
    {
        $this->witnessesRepresentative = $witnessesRepresentative;
        $this->action = $action;
        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = WitnessesRepresentativeAdminDto::fromLiveWireModel($this->witnessesRepresentative);
            $service = new WitnessesRepresentativeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.witnesses_representative_created_successfully'));
                    return redirect()->route('admin.ejalas.witnesses_representatives.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->witnessesRepresentative, $dto);
                    $this->successFlash(__('ejalas::ejalas.witnesses_representative_updated_successfully'));
                    return redirect()->route('admin.ejalas.witnesses_representatives.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.witnesses_representatives.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
