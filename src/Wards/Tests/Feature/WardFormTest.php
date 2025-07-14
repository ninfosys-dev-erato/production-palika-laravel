<?php

namespace Src\Wards\Tests\Feature;

use App\Enums\Action;
use Livewire\Livewire;
use App\Models\User;
use Src\Wards\Models\Ward;
use Src\Wards\Livewire\WardForm;
use Src\Wards\Tests\TestData\WardForm_TestData;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class WardFormTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(1) ?? User::factory()->create(['id' => 1]);
        $this->actingAs($this->user);
    }

    #[Test]
    public function it_renders_component()
    {
        $this->get(route('admin.wards.create'))->assertSeeLivewire(WardForm::class);
    }

    #[Test]
    public function it_validates_ward_address_en_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.address_en', '')
            ->call('save')
            ->assertHasErrors('ward.address_en')
            ->assertSee(__('wards::wards.address_en_is_required'));
    }

    #[Test]
    public function it_validates_ward_address_ne_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.address_ne', '')
            ->call('save')
            ->assertHasErrors('ward.address_ne')
            ->assertSee(__('wards::wards.address_ne_is_required'));
    }

    #[Test]
    public function it_validates_ward_email_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.email', '')
            ->call('save')
            ->assertHasErrors('ward.email')
            ->assertSee(__('wards::wards.email_is_required'));
    }

    #[Test]
    public function it_validates_ward_id_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.id', '')
            ->call('save')
            ->assertHasNoErrors('ward.id');
    }

    #[Test]
    public function it_validates_ward_phone_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.phone', '')
            ->call('save')
            ->assertHasErrors('ward.phone')
            ->assertSee(__('wards::wards.phone_is_required'));
    }

    #[Test]
    public function it_validates_ward_ward_name_en_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.ward_name_en', '')
            ->call('save')
            ->assertHasErrors('ward.ward_name_en')
            ->assertSee(__('wards::wards.ward_name_en_is_required'));
    }

    #[Test]
    public function it_validates_ward_ward_name_ne_is_required()
    {
        Livewire::test(WardForm::class,[
            'wards' => new Ward(),
            'action' => Action::CREATE
        ])
            ->set('ward.ward_name_ne', '')
            ->call('save')
            ->assertHasErrors('ward.ward_name_ne')
            ->assertSee(__('wards::wards.ward_name_ne_is_required'));
    }

    #[Test]   
    public function it_can_save_with_valid_data()
    {
        $testData = WardForm_TestData::validData();


        Livewire::test(WardForm::class,[
         'wards'=> new Ward(),
         'action'=> Action::CREATE
])
            ->set('ward.address_en', $testData['address_en'] ?? '')
            ->set('ward.address_ne', $testData['address_ne'] ?? '')
            ->set('ward.email', $testData['email'] ?? '')
            ->set('ward.id', $testData['id'] ?? '')
            ->set('ward.phone', $testData['phone'] ?? '')
            ->set('ward.ward_name_en', $testData['ward_name_en'] ?? '')
            ->set('ward.ward_name_ne', $testData['ward_name_ne'] ?? '')
            ->call('save')
            ->assertHasNoErrors();
    }
}
