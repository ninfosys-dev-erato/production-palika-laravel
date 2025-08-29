<?php

namespace Src\Beruju\Livewire;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Models\BerujuEntry;

class ReviewForm extends Component
{
	use SessionFlash;

	public ?BerujuEntry $berujuEntry = null;
	public string $decision = 'approved';
	public string $remarks = '';

	public function rules(): array
	{
		return [
			'decision' => ['required', 'in:approved,rejected'],
			'remarks' => ['nullable', 'string', 'max:1000'],
		];
	}

	public function mount(BerujuEntry $berujuEntry = null): void
	{
		$this->berujuEntry = $berujuEntry;
	}

	#[On('open-review-modal')]
	public function loadEntry(int $entryId): void
	{
		$this->berujuEntry = BerujuEntry::findOrFail($entryId);
	}

	public function submit(): void
	{
		$this->validate();

		if (!$this->berujuEntry) {
			$this->errorFlash(__('beruju::beruju.something_went_wrong_while_saving'));
			return;
		}

		try {
			if ($this->decision === 'approved') {
				$this->berujuEntry->status = BerujuStatusEnum::RESOLVED;
				$this->berujuEntry->save();
				$this->successFlash(__('beruju::beruju.beruju_resolved_successfully'));
			} else {
				$this->berujuEntry->status = BerujuStatusEnum::REJECTED;
				$this->berujuEntry->save();
				$this->successFlash(__('beruju::beruju.beruju_rejected_successfully'));
			}

			$this->dispatch('close-modal');
			$this->dispatch('reload-page');
		} catch (\Throwable $e) {
			$this->errorFlash($e->getMessage());
		}
	}

	public function render()
	{
		return view('Beruju::livewire.review-form');
	}
}


