<?php

namespace Frontend\TokenPortal\TokenTv\Livewire;
use Livewire\Attributes\On;
use Src\TokenTracking\Models\RegisterToken;
use Carbon\Carbon;


use Livewire\Component;

class RegisterTokenTable extends Component
{

  protected $listeners = ['refreshTokens'];

  public $start = 10;
  public $tokens;



  public function mount()
  {
      $this->loadTokens();
  }


  #[On('refreshTokens')]
  public function loadTokens()
  {
      $today = Carbon::today();
  
      $this->tokens = RegisterToken::with([
          'branches',
          'currentBranch',
          'tokenHolder',
          'stageStatus',
          'logs',
          'logs.oldBranch',
          'logs.currentBranch'
      ]) // Assuming 'logs' is a relationship
          ->whereDate('created_at', $today)
          ->whereNull('exit_time')
          ->whereNull('deleted_at')
          ->whereNull('deleted_by')
          ->orderByRaw('COALESCE(updated_at, created_at) DESC')
          ->get();
  }
  



    public function render()
    {
        return view("TokenPortal.TokenTv::register-token-table");
    }
}
