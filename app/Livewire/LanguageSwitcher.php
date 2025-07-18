<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    protected $listeners = ['changeLanguage'];
    
    public $language;

    public function mount()
    {
        $this->language = Cookie::get('language', config('app.locale'));
        App::setLocale($this->language);
    }

    public function changeLanguage($language)
    {
        App::setLocale($language);
        Cookie::queue('language', $language, 60 * 24 * 365);

        $this->language = $language;
        $this->dispatch('language-change');
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
