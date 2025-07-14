<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Employees\Models\Employee;
use Src\Yojana\DTO\LogBookAdminDto;
use Src\Yojana\Models\LogBook;
use Src\Yojana\Service\LogBookAdminService;

class LogBookForm extends Component
{
    use SessionFlash;

    public ?LogBook $logBook;
    public ?Action $action;
    public $employees;

    public function rules(): array
    {
        return [
    'logBook.employee_id' => ['required'],
    'logBook.date' => ['required'],
    'logBook.visit_time' => ['required'],
    'logBook.return_time' => ['required'],
    'logBook.visit_type' => ['required'],
    'logBook.visit_purpose' => ['required'],
    'logBook.description' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'logBook.employee_id.required' => __('yojana::yojana.employee_id_is_required'),
            'logBook.date.required' => __('yojana::yojana.date_is_required'),
            'logBook.visit_time.required' => __('yojana::yojana.visit_time_is_required'),
            'logBook.return_time.required' => __('yojana::yojana.return_time_is_required'),
            'logBook.visit_type.required' => __('yojana::yojana.visit_type_is_required'),
            'logBook.visit_purpose.required' => __('yojana::yojana.visit_purpose_is_required'),
            'logBook.description.required' => __('yojana::yojana.description_is_required'),
        ];
    }

    public function render(){
        return view("Yojana::livewire.log-books.form");
    }

    public function mount(LogBook $logBook,Action $action)
    {
        $this->logBook = $logBook;
        $this->action = $action;
        $this->employees = Employee::pluck('name', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = LogBookAdminDto::fromLiveWireModel($this->logBook);
        $service = new LogBookAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.log_book_created_successfully'));
                return redirect()->route('admin.log_books.index');
                break;
            case Action::UPDATE:
                $service->update($this->logBook,$dto);
                $this->successFlash(__('yojana::yojana.log_book_updated_successfully'));
                return redirect()->route('admin.log_books.index');
                break;
            default:
                return redirect()->route('admin.log_books.index');
                break;
        }
    }
}
