<?php

namespace Src\Grievance\Tests\Browser\Components;

use App\Models\User;
use Laravel\Dusk\Browser;
use Src\Grievance\Database\Factories\GrievanceTypeFactory;
use Tests\DuskTestCase;

class GrievanceTypeTableTest extends DuskTestCase
{
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::find(1);
    }

    public function test_datatable_shows_grievance_type()
    {

        GrievanceTypeFactory::new()->create(['title' => 'Dusk Page']);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('admin/grievances/grievance-type')
                ->pause(500)
                ->assertSee('Dusk Page');
        });
    }

    public function test_requires_grievance_type_title_field()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.grievance.grievanceType.create'))
                ->pause(5000)
                ->press('Save')
                ->pause(5000)
                ->waitForText('The title is required.')
                ->assertSee('The title is required.')
                ->screenshot('grievance_type_validation-shown');
        });
    }
    public function test_user_can_create_grievance_type()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(route('admin.grievance.grievanceType.create'))
                ->type('@title', 'Test Grievance Type')
            ;
            $browser->press('Save')
                ->waitForLocation(route('admin.grievance.grievanceType.create'), 5) // ⏳ Wait for redirect
                ->assertUrlIs(route('admin.grievance.grievanceType.create'));
            $browser->screenshot('screenshot-create-grievance-page');
        });
    }
}
