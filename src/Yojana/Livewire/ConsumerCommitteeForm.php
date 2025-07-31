<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Wards\Models\Ward;
use Src\Yojana\DTO\ConsumerCommitteeAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\BankDetail;
use Src\Yojana\Models\CommitteeType;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Service\ConsumerCommitteeAdminService;

class ConsumerCommitteeForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?ConsumerCommittee $consumerCommittee;
    public ?Action $action;

    public $Committee_type;

    public $wards;
    public $banks;

    public $formation_minute;
    public $formation_minute_url;
    public $formation_minute_saved;

    public function rules(): array
    {
        return [
    'consumerCommittee.committee_type_id' => ['required'],
    'consumerCommittee.registration_number' => ['required'],
    'consumerCommittee.formation_date' => ['required'],
    'consumerCommittee.name' => ['required'],
    'consumerCommittee.ward_id' => ['required'],
    'consumerCommittee.address' => ['required'],
    'consumerCommittee.creating_body' => ['required'],
    'consumerCommittee.number_of_attendees' => ['required'],
    'consumerCommittee.bank_id' => ['required'],
    'consumerCommittee.account_number' => ['required'],
    'consumerCommittee.formation_minute' => ['nullable'],
];
    }
    public function messages(): array
    {
        return [
            'consumerCommittee.committee_type_id.required' => __('yojana::yojana.committee_type_id_is_required'),
            'consumerCommittee.registration_number.required' => __('yojana::yojana.registration_number_is_required'),
            'consumerCommittee.formation_date.required' => __('yojana::yojana.formation_date_is_required'),
            'consumerCommittee.name.required' => __('yojana::yojana.name_is_required'),
            'consumerCommittee.ward_id.required' => __('yojana::yojana.ward_id_is_required'),
            'consumerCommittee.address.required' => __('yojana::yojana.address_is_required'),
            'consumerCommittee.number_of_attendees.required' => __('yojana::yojana.number_of_attendees_is_required'),
            'consumerCommittee.creating_body.required' => __('yojana::yojana.creating_body_is_required'),
            'consumerCommittee.bank_id.required' => __('yojana::yojana.bank_id_is_required'),
            'consumerCommittee.account_number.required' => __('yojana::yojana.account_number_is_required'),
            'consumerCommittee.formation_minute.required' => __('yojana::yojana.formation_minute_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.consumer-committees.form");
    }

    public function mount(ConsumerCommittee $consumerCommittee,Action $action)
    {
        $this->consumerCommittee = $consumerCommittee;
        $this->action = $action;
        $this->Committee_type = CommitteeType::pluck("name", "id");
        $this->wards = Ward::pluck("ward_name_en", "id");
        $this->banks = BankDetail::pluck("title", "id");
        session()->put('redirect_url', url()->current());
        $this->handleFileUpload(null, 'formation_minute', 'formation_minute_url');

    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.consumer-committee'),
                file: $file,
                disk: getStorageDisk('private'),
                filename: ""
            );

            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.consumer-committee'),
                filename: $save,
                disk: getStorageDisk('private')
            );

            if ($save) {
                return $save;
            } else {
                $this->errorFlash("File Couldn't Be Uploaded");
            }
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->consumerCommittee?->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.consumer-committee'),
                    filename: $this->consumerCommittee->{$modelField},
                    disk: getStorageDisk('private')
                );
            }
        }
    }


    public function updatedFormationMinute()
    {
        $saved_image = $this->handleFileUpload($this->formation_minute, 'formation_minute', 'formation_minute_url');
        $this->formation_minute_saved = $saved_image;
    }


    public function save()
    {
        $this->validate();
        $this->consumerCommittee->formation_minute = $this?->formation_minute_saved ?? "";
        $dto = ConsumerCommitteeAdminDto::fromLiveWireModel($this->consumerCommittee);

        $service = new ConsumerCommitteeAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.consumer_committee_created_successfully'));
                return redirect()->route('admin.consumer_committees.index');
                break;
            case Action::UPDATE:
                $service->update($this->consumerCommittee,$dto);
                $this->successFlash(__('yojana::yojana.consumer_committee_updated_successfully'));
                return redirect()->route('admin.consumer_committees.index');
                break;
            default:
                return redirect()->route('admin.consumer_committees.index');
                break;
        }
    }

}
