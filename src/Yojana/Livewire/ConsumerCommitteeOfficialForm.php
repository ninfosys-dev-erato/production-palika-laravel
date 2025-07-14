<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ConsumerCommitteeOfficialAdminDto;
use Src\Yojana\Models\ConsumerCommitteeOfficial;
use Src\Yojana\Service\ConsumerCommitteeOfficialAdminService;

class ConsumerCommitteeOfficialForm extends Component
{
    use SessionFlash;

    public ?ConsumerCommitteeOfficial $consumerCommitteeOfficial;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'consumerCommitteeOfficial.consumer_committee_id' => ['required'],
    'consumerCommitteeOfficial.post' => ['required'],
    'consumerCommitteeOfficial.name' => ['required'],
    'consumerCommitteeOfficial.father_name' => ['required'],
    'consumerCommitteeOfficial.grandfather_name' => ['required'],
    'consumerCommitteeOfficial.address' => ['required'],
    'consumerCommitteeOfficial.gender' => ['required'],
    'consumerCommitteeOfficial.phone' => ['required'],
    'consumerCommitteeOfficial.citizenship_no' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'consumerCommitteeOfficial.consumer_committee_id.required' => __('yojana::yojana.consumer_committee_id_is_required'),
            'consumerCommitteeOfficial.post.required' => __('yojana::yojana.post_is_required'),
            'consumerCommitteeOfficial.name.required' => __('yojana::yojana.name_is_required'),
            'consumerCommitteeOfficial.father_name.required' => __('yojana::yojana.father_name_is_required'),
            'consumerCommitteeOfficial.grandfather_name.required' => __('yojana::yojana.grandfather_name_is_required'),
            'consumerCommitteeOfficial.address.required' => __('yojana::yojana.address_is_required'),
            'consumerCommitteeOfficial.gender.required' => __('yojana::yojana.gender_is_required'),
            'consumerCommitteeOfficial.phone.required' => __('yojana::yojana.phone_is_required'),
            'consumerCommitteeOfficial.citizenship_no.required' => __('yojana::yojana.citizenship_no_is_required'),
        ];
    }

    public function render(){
        return view("ConsumerCommitteeOfficials::livewire.form");
    }

    public function mount(ConsumerCommitteeOfficial $consumerCommitteeOfficial,Action $action)
    {
        $this->consumerCommitteeOfficial = $consumerCommitteeOfficial;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ConsumerCommitteeOfficialAdminDto::fromLiveWireModel($this->consumerCommitteeOfficial);
        $service = new ConsumerCommitteeOfficialAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Consumer Committee Official Created Successfully");
                return redirect()->route('admin.consumer_committee_officials.index');
                break;
            case Action::UPDATE:
                $service->update($this->consumerCommitteeOfficial,$dto);
                $this->successFlash("Consumer Committee Official Updated Successfully");
                return redirect()->route('admin.consumer_committee_officials.index');
                break;
            default:
                return redirect()->route('admin.consumer_committee_officials.index');
                break;
        }
    }
}
