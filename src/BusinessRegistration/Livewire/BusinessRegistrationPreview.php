<?php

namespace Src\BusinessRegistration\Livewire;

use App\Traits\SessionFlash;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Service\BusinessRegistrationAdminService;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Src\Recommendation\Services\RecommendationService;

class BusinessRegistrationPreview extends Component
{
    use SessionFlash, BusinessRegistrationTemplate;
    public ?BusinessRegistration $businessRegistration;

    public $letter;
    public $template;
    public $style;

    public function mount(BusinessRegistration $businessRegistration)
    {
        $this->businessRegistration = $businessRegistration;

        $this->style = $this->businessRegistration->registrationType->form?->styles ?? "";
        // $this->template = $this->resolveTemplate($this->businessRegistration);
        $this->template = $this->resolveTemplate($this->businessRegistration);
    }

    public function render()
    {
        return view('BusinessRegistration::livewire.business-registration.preview');
    }

    // #[On('print-preview-business')]
    public function print()
    {
        $service = new BusinessRegistrationAdminService();
        return $service->getLetter($this->businessRegistration, 'web');
    }
}
