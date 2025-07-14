<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Yojana\DTO\TestListAdminDto;
use Src\Yojana\Models\TestList;
use Src\Yojana\Service\TestListAdminService;

class TestListForm extends Component
{
    use SessionFlash;

    public ?TestList $testList;
    public ?Action $action;

    public bool $isForAgreement = false;


    public function rules(): array
    {
        return [
    'testList.title' => ['required'],
    'testList.type' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'testList.title.required' => __('yojana::yojana.title_is_required'),
            'testList.type.required' => __('yojana::yojana.type_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.test-lists.form");
    }

    public function mount(TestList $testList,Action $action)
    {
        $this->testList = $testList;
        $this->action = $action;

        if ($action === Action::UPDATE){
            $this->isForAgreement = $this->testList->is_for_agreement;
        }
    }

    public function save()
    {
        $this->validate();
        $this->testList->is_for_agreement = $this->isForAgreement;
        $dto = TestListAdminDto::fromLiveWireModel($this->testList);
        $service = new TestListAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.test_list_created_successfully'));
//                return redirect()->route('admin.test_lists.index');
                break;
            case Action::UPDATE:
                $service->update($this->testList,$dto);
                $this->successFlash(__('yojana::yojana.test_list_updated_successfully'));
//                return redirect()->route('admin.test_lists.index');
                break;
            default:
                return redirect()->route('admin.test_lists.index');
                break;
        }
        $this->dispatch('close-modal');
    }

    #[On('edit-test-list')]
    public function editTestList(TestList $testList){
        $this->testList = $testList;
        $this->action = Action::UPDATE;
        $this->isForAgreement = $this->testList->is_for_agreement;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetTestList()
    {
        $this->reset(['testList','isForAgreement', 'action']);
        $this->testList = new TestList();
    }
}
