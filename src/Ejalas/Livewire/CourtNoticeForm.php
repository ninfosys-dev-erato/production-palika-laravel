<?php

namespace Src\Ejalas\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ejalas\DTO\CourtNoticeAdminDto;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\CourtNotice;
use Src\Ejalas\Models\ReconciliationCenter;
use Src\Ejalas\Service\CourtNoticeAdminService;
use Src\Settings\Models\FiscalYear;

class CourtNoticeForm extends Component
{
    use SessionFlash, HelperDate;

    public ?CourtNotice $courtNotice;
    public ?Action $action;
    public $complainRegistrations;
    public $complaintData = [];

    public $complainers = [];
    public $defenders = [];
    public $reconciliationCenters;
    public $fiscalYears;

    public function rules(): array
    {
        return [
            'courtNotice.notice_no' => ['required'],
            'courtNotice.fiscal_year_id' => ['required'],
            'courtNotice.complaint_registration_id' => ['required'],
            'courtNotice.reference_no' => ['required'],
            'courtNotice.notice_date' => ['required'],
            'courtNotice.notice_time' => ['required'],
            'courtNotice.reconciliation_center_id' => ['required'],
        ];
    }

    public function render()
    {
        return view("Ejalas::livewire.court-notice.form");
    }

    public function mount(CourtNotice $courtNotice, Action $action)
    {
        $this->courtNotice = $courtNotice;
        $this->action = $action;

        $nextId = CourtNotice::max('id') + 1;
        $this->courtNotice->notice_no = $nextId;
        $this->courtNotice->notice_time = now()->format('H:i');

        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->complainRegistrations = ComplaintRegistration::whereNull('deleted_at')->where('status', true)->with('parties')
            ->get()
            ->mapWithKeys(function ($complaint) {
                $partyNames = $complaint->parties->pluck('name')->implode(', ');
                return [$complaint->id => $complaint->reg_no . ' (' . $partyNames . ')'];
            });
        $this->reconciliationCenters = ReconciliationCenter::whereNull('deleted_at')->pluck('reconciliation_center_title', 'id');

        if ($action == Action::UPDATE) {
            $this->getComplaintRegistration();
            // $this->courtNotice->notice_date = replaceNumbers($this->adToBs($this->courtNotice->notice_date), true);
        }
    }
    public function getComplaintRegistration()
    {
        $complaintRegistrationId = $this->courtNotice['complaint_registration_id'];
        $this->complaintData = ComplaintRegistration::with([
            'fiscalYear',
            'priority',
            'disputeMatter',
            'parties'
        ])->find($complaintRegistrationId)?->toArray() ?? [];


        if (!empty($this->complaintData)) {
            // Access parties through the relationship
            $parties = collect($this->complaintData['parties'] ?? []);

            // Separate complainers and defenders using pivot data
            $this->complainers = $parties->filter(function ($party) {
                return $party['pivot']['type'] === 'Complainer';
            })->pluck('name')->toArray();

            $this->defenders = $parties->filter(function ($party) {
                return $party['pivot']['type'] === 'Defender';
            })->pluck('name')->toArray();
        } else {
            $this->complainers = [];
            $this->defenders = [];
        }

        if ($this->action  == Action::CREATE) {
            $count = CourtNotice::where('complaint_registration_id', $complaintRegistrationId)->count();
            $this->courtNotice['reference_no'] = $count + 1;
        }
    }

    public function save()
    {
        $this->validate();
        try {
            $dto = CourtNoticeAdminDto::fromLiveWireModel($this->courtNotice);
            $service = new CourtNoticeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('ejalas::ejalas.court_notice_created_successfully'));
                    return redirect()->route('admin.ejalas.court_notices.index');
                    break;
                case Action::UPDATE:
                    $service->update($this->courtNotice, $dto);
                    $this->successFlash(__('ejalas::ejalas.court_notice_updated_successfully'));
                    return redirect()->route('admin.ejalas.court_notices.index');
                    break;
                default:
                    return redirect()->route('admin.ejalas.court_notices.index');
                    break;
            }
        } catch (\Throwable $e) {
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
