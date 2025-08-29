<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Models\BerujuEntry;

class SendForReview extends Component
{
	use SessionFlash;

	public ?BerujuEntry $berujuEntry = null;
	public string $remarks = '';

	public function rules(): array
	{
		return [
			'remarks' => ['nullable'],
		];
	}

	public function mount(BerujuEntry $berujuEntry = null): void
	{
		$this->berujuEntry = $berujuEntry;
	}

	#[On('open-send-for-review')]
	public function loadEntry(int $entryId): void
	{
		$this->berujuEntry = BerujuEntry::findOrFail($entryId);
	}

	public function send(): void
	{
		$this->validate();

		if (!$this->berujuEntry) {
			$this->errorFlash(__('beruju::beruju.something_went_wrong_while_saving'));
			return;
		}

		try {
			// Update statuses to UNDER_REVIEW
			$this->berujuEntry->status = BerujuStatusEnum::UNDER_REVIEW;

			$this->berujuEntry->save();

			$this->successFlash(__('beruju::beruju.sent_for_review_successfully'));
			$this->dispatch('close-modal');
			$this->dispatch('reload-page');
			$this->remarks = '';
		} catch (\Throwable $e) {
			$this->errorFlash($e->getMessage());
		}
	}

	public function render()
	{
		return view('Beruju::livewire.send-for-review');
	}
}


