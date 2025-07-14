<?php

namespace App\Livewire;

use App\Services\NidService;
use App\Traits\SessionFlash;
use Livewire\Component;

class NidValidationForm extends Component
{
    use SessionFlash;
    public string $nin = '';
    public string $fullName = '';
    public string $gender = '';
    public string $dobLoc = '';

    public bool $verificationPassed = false;
    public bool $verified = false;

    public function submit()
    {
        $this->reset('verified', 'verificationPassed');
        $this->validate([
            'nin' => 'required|string|min:8',
            'fullName' => 'required|string',
            'gender' => 'required|in:M,F',
            'dobLoc' => 'required|string',
        ]);
        $_service = new NidService();
        try {
            $this->verificationPassed =$_service->verifyNid(
                $this->nin,
                $this->fullName,
                $this->gender,
                replaceNumbers($this->dobLoc,true)
            );
            $this->verified = true;
        } catch (\Throwable $e) {
           $this->warningFlash(__($e->getMessage()));
        }
    }

    public function render()
    {
        return view('livewire.nid-validation-form');
    }

}
