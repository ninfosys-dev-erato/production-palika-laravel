<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProjectBidSubmissionAdminDto;
use Src\Yojana\Models\ProjectBidSubmission;
use Src\Yojana\Service\ProjectBidSubmissionAdminService;

class ProjectBidSubmissionForm extends Component
{
    use SessionFlash;

    public ?ProjectBidSubmission $projectBidSubmission;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'projectBidSubmission.project_id' => ['required'],
    'projectBidSubmission.submission_type' => ['required'],
    'projectBidSubmission.submission_no' => ['required'],
    'projectBidSubmission.date' => ['required'],
    'projectBidSubmission.amount' => ['required'],
    'projectBidSubmission.fiscal_year_id' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'projectBidSubmission.project_id.required' => __('yojana::yojana.project_id_is_required'),
            'projectBidSubmission.submission_type.required' => __('yojana::yojana.submission_type_is_required'),
            'projectBidSubmission.submission_no.required' => __('yojana::yojana.submission_no_is_required'),
            'projectBidSubmission.date.required' => __('yojana::yojana.date_is_required'),
            'projectBidSubmission.amount.required' => __('yojana::yojana.amount_is_required'),
            'projectBidSubmission.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
        ];
    }

    public function render(){
        return view("project-bid-submissions::projects.form");
    }

    public function mount(ProjectBidSubmission $projectBidSubmission,Action $action)
    {
        $this->projectBidSubmission = $projectBidSubmission;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ProjectBidSubmissionAdminDto::fromLiveWireModel($this->projectBidSubmission);
        $service = new ProjectBidSubmissionAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Project Bid Submission Created Successfully");
                return redirect()->route('admin.project_bid_submissions.index');
                break;
            case Action::UPDATE:
                $service->update($this->projectBidSubmission,$dto);
                $this->successFlash("Project Bid Submission Updated Successfully");
                return redirect()->route('admin.project_bid_submissions.index');
                break;
            default:
                return redirect()->route('admin.project_bid_submissions.index');
                break;
        }
    }
}
