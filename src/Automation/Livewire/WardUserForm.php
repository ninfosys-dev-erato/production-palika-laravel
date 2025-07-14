<?php

namespace Src\Automation\Livewire;

use App\Models\User;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Src\Address\Models\LocalBody;
use Src\Roles\Models\Role;
use Src\Users\Models\UserWard;
use Src\Wards\Models\Ward;

class WardUserForm extends Component
{
    use SessionFlash;
    public $palika;
    public $count;
    public $roles;
    public $role_id;


    public function mount()
    {
        $this->roles = Role::get();

    }

    public function render()
    {
        return view('Automation::livewire.ward-user-generator');
    }

    public function generateUsers()
    {
        DB::beginTransaction();

        try {
            

            $palika = strtolower(str_replace(' ', '', $this->palika));
            $count = (int) $this->count;

            for ($i = 1; $i <= $count; $i++) {
                $email = "ward{$i}@{$palika}.gov.np";
                $mobile_no = "980000000{$i}";

                if (!User::where('email', $email)->exists()) {
                    $user = User::create([
                        'name' => "Ward {$i}",
                        'email' => $email,
                        'password' => Hash::make('password'),
                        'mobile_no' => $mobile_no,
                        'active' => true,
                    ]);

                    $user->assignRole($this->role_id);

                    UserWard::create([
                        'user_id' => $user->id,
                        'ward' => $i,
                        'local_body_id' =>  key(getSettingWithKey('palika-local-body'))
                    ]);
                }
            }

            DB::commit(); 

            $this->successFlash(__('Created Successfully'));
            $this->reset(['palika', 'count']);

        } catch (\Exception $e) {
            DB::rollBack(); 

            logger()->error('User generation failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

             $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }

    }

    public function generateWards()
    {
        $localBodyId = key(getSettingWithKey('palika-local-body')); 
        $localBody = LocalBody::findOrFail($localBodyId);
        $wardCount = $localBody->wards;
        $localBodyEn = $localBody->title_en;
        $localBodyNe = $localBody->title;
        
        for ($i = 1; $i <= $wardCount; $i++) {
            $nepaliNo = replaceNumbers($i, true);
            if (!Ward::where('id', $i)->where('local_body_id', $localBodyId)->exists()) {
                Ward::create([
                    'id' => $i,
                    'local_body_id' => $localBodyId,
                    'ward_name_en' => "{$localBodyEn} {$i} no. Ward Office",
                    'ward_name_ne' => "{$localBodyNe} {$nepaliNo} नं. वडा कार्यालय",
                ]);
            }
        }

        $this->successFlash(__('Created Successfully'));

    }
}
