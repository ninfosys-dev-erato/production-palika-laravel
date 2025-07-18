<?php

namespace Src\Employees\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Attributes\On;
use Src\Employees\DTO\BranchAdminDto;
use Src\Employees\Models\Branch;
use Src\Employees\Service\BranchAdminService;
use AllowDynamicProperties;

#[AllowDynamicProperties]
class BranchIndex extends Component
{
    use SessionFlash;

    /** @var Branch|null */
    public ?Branch $branch;

    /** @var Action|null */
    public ?Action $action = Action::CREATE;

    // Holds the list of branches
    public $branches;

    public function render()
    {
        return view("Employees::livewire.branch.index");
    }

    public function mount(): void
    {
        $this->resetForm();
        $locale = app()->getLocale();
        $this->branches = Branch::query()->whereNull('deleted_at')->get(['id', 'title', 'title_en'])
            ->map(function ($item) use ($locale) {
                // Conditionally set the 'name' field based on the locale
                $item->title = $locale != 'en' ? $item->title : $item->title_en;
                unset($item->title_en); // Remove the unnecessary field
                return $item;
            });
    }
    /**
     * Called when the edit button is clicked.
     * Accepts the branch id as an integer, loads the branch, sets the action to UPDATE,
     * and dispatches an event to open the modal.
     */
    public function editBranch(int $id)
    {
        $this->branch = Branch::findOrFail($id);
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    /**
     * Resets the form by setting $branch to a new Branch instance and the action to CREATE.
     */
    private function resetForm()
    {
        $this->branch = new Branch();
        $this->action = Action::CREATE;
    }

    #[On('reset-form')]
    public function resetBranch()
    {
        $this->resetForm();
    }
}
