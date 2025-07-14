<?php

namespace Src\TokenTracking\Livewire;

use App\Enums\Action;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\TokenTracking\DTO\RegisterTokenAdminDto;
use Src\TokenTracking\DTO\TokenHolderAdminDto;
use Src\TokenTracking\Models\RegisterToken;
use Src\TokenTracking\Models\TokenHolder;
use Src\TokenTracking\Service\RegisterTokenAdminService;

class RegisterTokenForm extends Component
{
    use SessionFlash, HelperDate;

    public ?RegisterToken $registerToken;
    public ?TokenHolder $tokenHolder;
    public ?Action $action;
    public $branches = [];

    public $selectedDepartments = [];
    public $currentBranches = [];

    public function rules(): array
    {
        return [
            'registerToken.token' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today()->toDateString(); // Get today's date in Y-m-d format
                    $exists = RegisterToken::where('token', $value)
                        ->whereDate('created_at', $today) // Check if token exists today
                        ->exists();

                    if ($exists) {
                        $fail(__('tokentracking::tokentracking.the_attribute_must_be_unique_for_today'));
                    }
                },
            ],
            'registerToken.token_purpose' => ['required', 'string'],
            'registerToken.fiscal_year' => ['required'],
            'registerToken.date' => ['required'],
            'registerToken.current_branch' => ['required'],
            'registerToken.entry_time' => ['nullable'],
            'registerToken.exit_time' => ['nullable'],
            'registerToken.estimated_time' => ['nullable'],
            'tokenHolder.name' => ['required'],
            'tokenHolder.email' => ['nullable'],
            'tokenHolder.mobile_no' => ['required'],
            'tokenHolder.address' => ['required'],
        ];
    }

    public function render()
    {
        return view("TokenTracking::livewire.form");
    }

    public function mount(RegisterToken $registerToken, Action $action, TokenHolder $tokenHolder)
    {
        $this->registerToken = $registerToken;
        $this->tokenHolder = $tokenHolder;
        $this->registerToken->fiscal_year = getSetting('fiscal-year');
        $this->action = $action;

        $this->branches = Branch::all(['id', 'title'])
            ->mapWithKeys(fn($branch) => [$branch->id => $branch->title])
            ->toArray();
        $this->currentBranches = Branch::whereNull('deleted_at')->get()->toArray();

        if ($this->action === Action::UPDATE) {
            $this->selectedDepartments = $registerToken->branches()?->pluck('mst_branches.id')->toArray();
            $this->tokenHolder = TokenHolder::where('token_id', $this->registerToken->id)->first();
        } else {
            $this->registerToken->date = $this->convertEnglishToNepali($this->adToBs(date('Y-m-d')));
        }
    }
    public function save()
    {
        $this->validate();
        $this->registerToken->date_en = $this->bsToAd($this->registerToken->date);
        $dto = RegisterTokenAdminDto::fromLiveWireModel($this->registerToken);
        $tokenHolderDto = TokenHolderAdminDto::fromLiveWireModel($this->tokenHolder);
        $service = new RegisterTokenAdminService();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $token = $service->store($dto, $tokenHolderDto, $this->selectedDepartments);
                    if ($token instanceof RegisterToken) {
                        $this->dispatch('refreshTokens');
                        if (app()->isProduction()) {
                            if (!$service->tokenCreateMessage($token)) {
                                $this->warningToast(__('tokentracking::tokentracking.sms_failed_'));
                            }
                        }
                        $this->successToast(__('tokentracking::tokentracking.register_token_created_successfully'));
                    } else {
                        $this->errorFlash(__('tokentracking::tokentracking.register_token_creation_failed_'));
                    }
                    return redirect()->route('admin.register_tokens.create');
                case Action::UPDATE:
                    $token = $service->update($this->registerToken, $dto, $tokenHolderDto, $this->selectedDepartments);
                    if ($token) {
                        $this->successFlash(__('tokentracking::tokentracking.register_token_updated_successfully'));
                        $this->dispatch('refreshTokens');
                        return redirect()->route('admin.register_tokens.index');
                    } else {
                        $this->errorFlash(__('tokentracking::tokentracking.update_token_failed_'));
                    }
                    break;
                default:
                    return redirect()->route('admin.register_tokens.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorFlash(__('tokentracking::tokentracking.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    #[On('search-user')]
    public function restructureData(array $result)
    {
        $this->tokenHolder->name = $result['name'];
        $this->tokenHolder->mobile_no = $result['mobile_no'];
        $this->tokenHolder->email = $result['email'];
    }
}
