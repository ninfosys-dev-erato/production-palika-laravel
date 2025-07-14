<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Yojana\DTO\ConsumerCommitteeMemberAdminDto;
use Src\Yojana\Enums\ConsumerCommitteeMemberDesgination;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\ConsumerCommitteeMember;
use Src\Yojana\Service\ConsumerCommitteeMemberAdminService;

class ConsumerCommitteeMemberForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?ConsumerCommitteeMember $consumerCommitteeMember;
    public ?Action $action;
    public $designations;

    //for file upload
    public $citizenship;
    public $citizenshipUrl;
    public $consumerCommitteeId;

    public function rules(): array
    {
        return [
            'consumerCommitteeMember.consumer_committee_id' => ['nullable'],
            'consumerCommitteeMember.citizenship_number' => ['required'],
            'consumerCommitteeMember.name' => ['required'],
            'consumerCommitteeMember.gender' => ['required'],
            'consumerCommitteeMember.father_name' => ['required'],
            'consumerCommitteeMember.husband_name' => ['nullable'],
            'consumerCommitteeMember.grandfather_name' => ['nullable'],
            'consumerCommitteeMember.father_in_law_name' => ['nullable'],
            'consumerCommitteeMember.is_monitoring_committee' => ['nullable'],
            'consumerCommitteeMember.designation' => ['required'],
            'consumerCommitteeMember.address' => ['required'],
            'consumerCommitteeMember.mobile_number' => ['required' ,'digits:10'],
            'consumerCommitteeMember.is_account_holder' => ['nullable'],
            'consumerCommitteeMember.citizenship_upload' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'consumerCommitteeMember.citizenship_number.required' => __('yojana::yojana.citizenship_number_is_required'),
            'consumerCommitteeMember.name.required' => __('yojana::yojana.name_is_required'),
            'consumerCommitteeMember.gender.required' => __('yojana::yojana.gender_is_required'),
            'consumerCommitteeMember.father_name.required' => __('yojana::yojana.father_name_is_required'),
            'consumerCommitteeMember.husband_name.required' => __('yojana::yojana.husband_name_is_required'),
            'consumerCommitteeMember.grandfather_name.required' => __('yojana::yojana.grandfather_name_is_required'),
            'consumerCommitteeMember.father_in_law_name.required' => __('yojana::yojana.father_in_law_name_is_required'),
            'consumerCommitteeMember.is_monitoring_committee.required' => __('yojana::yojana.is_monitoring_committee_is_required'),
            'consumerCommitteeMember.designation.required' => __('yojana::yojana.designation_is_required'),
            'consumerCommitteeMember.address.required' => __('yojana::yojana.address_is_required'),
            'consumerCommitteeMember.is_account_holder.required' => __('yojana::yojana.is_account_holder_is_required'),
            'consumerCommitteeMember.citizenship_upload.required' => __('yojana::yojana.citizenship_upload_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.consumer-committee-members.form");
    }

    public function mount(ConsumerCommitteeMember $consumerCommitteeMember, Action $action, $consumerCommitteeId = null)
    {
        $this->consumerCommitteeId = $consumerCommitteeId;
        $this->consumerCommitteeMember = $consumerCommitteeMember;
        if ($this->consumerCommitteeMember->consumer_committee_id == null){
            $this->consumerCommitteeMember->consumer_committee_id = $this->consumerCommitteeId;
        }
        $this->action = $action;
        $this->designations = ConsumerCommitteeMemberDesgination::getForWeb();
        if ($action == Action::UPDATE) {
            $this->handleFileUpload(null, 'citizenship_upload', 'citizenshipUrl');
        }
        if (!session()->has('redirect_url')) {
            session()->put('redirect_url', url()->previous());
        }
    }


    public function save()
    {
        $this->validate();
        $dto = ConsumerCommitteeMemberAdminDto::fromLiveWireModel($this->consumerCommitteeMember);
        $service = new ConsumerCommitteeMemberAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.consumer_committee_member_created_successfully'));
                $this->redirect(session()->get('redirect_url'));
//                return redirect()->route('admin.consumer_committees.edit',$this->consumerCommitteeId);
                break;
            case Action::UPDATE:
                $service->update($this->consumerCommitteeMember, $dto);
                $this->successFlash(__('yojana::yojana.consumer_committee_member_updated_successfully'));
                $this->redirect(session()->get('redirect_url'));
                break;
            default:
//                return redirect()->route('admin.consumer_committee_members.index');
                break;
        }
    }
    public function updatedCitizenship()
    {
        $this->handleFileUpload($this->citizenship, 'citizenship_upload', 'citizenshipUrl');
    }
    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.evaluation'),
                file: $file,
                disk: "local",
                filename: ""
            );

            $this->consumerCommitteeMember->{$modelField} = $save;
            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.evaluation'),
                filename: $save,
                disk: 'local'
            );
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->consumerCommitteeMember->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.evaluation'),
                    filename: $this->consumerCommitteeMember->{$modelField},
                    disk: 'local'
                );
            }
        }
    }
}
