<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\SearchService;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Src\Committees\Models\CommitteeMember;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Employee;
use Src\Meetings\Models\InvitedMember;
use Src\TokenTracking\Models\TokenHolder;

class PhoneSearch extends Component
{
    public $phone; // Input for the phone number

    #[Modelable]
    public $result; // Search result
    public $modelsPriority; // Model priority list

    protected $rules = [
        'phone' => 'nullable',
    ];

    protected $searchService;

    public function boot(SearchService $searchService)
    {
        $this->searchService = $searchService;

        // Define model priority dynamically
        $this->modelsPriority = [
            Customer::class,
            Employee::class,
            CommitteeMember::class,
            InvitedMember::class,
            User::class,
            Employee::class,
            TokenHolder::class
        ];
    }

    public function search()
    {
        $this->validate();

        if (empty($this->phone)) {
            $this->result = null;
            return;
        }

        $this->result = $this->searchService->search($this->phone, $this->modelsPriority);

        if ($this->result) {
            $this->dispatch('search-user', result: $this->result);
        }
    }

    public function render()
    {
        return view('livewire.phone-search');
    }
}
