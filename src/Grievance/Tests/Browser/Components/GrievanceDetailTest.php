<?php

namespace Src\Grievance\Tests\Browser\Components;

use App\Models\User;
use Laravel\Dusk\Browser;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\Grievance\Database\Factories\GrievanceTypeFactory;
use Src\Grievance\Models\GrievanceType;
use Tests\DuskTestCase;

class GrievanceDetailTest extends DuskTestCase
{
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.debug' => false]);
        $this->adminUser = User::find(1);
    }

    // public function test_datatable_shows_grievance_type()
    // {

    //     GrievanceTypeFactory::new()->create(['title' => 'Dusk Page']);

    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs($this->adminUser)
    //             ->visit('admin/grievances/grievance-type')
    //             ->pause(500)
    //             ->assertSee('Dusk Page');
    //     });
    // }

    // public function test_requires_grievance_type_title_field()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs($this->adminUser)
    //             ->visit(route('admin.grievance.grievanceType.create'))
    //             ->pause(5000)
    //             ->press('Save')
    //             ->pause(5000)
    //             ->waitForText('The title is required.')
    //             ->assertSee('The title is required.')
    //             ->screenshot('grievance_type_validation-shown');
    //     });
    // }
    public function test_user_can_create_grievance_detail()
    {
        $customer = Customer::factory()->create();
        $grievanceType = GrievanceType::factory()->create();
        $department = Branch::factory()->create();
        $this->browse(function (Browser $browser) use ($customer, $grievanceType, $department) {
            $browser->loginAs(User::find(1))
                ->visit(route('admin.grievance.create'))
                ->select('@grievance-customer_id-field', $customer->id)
                ->check('@is_anonymous')
                ->type('@subject', 'subject')
                ->type('@description', 'description')
                ->select('@selectedDepartments', $department->id)
                ->select('@grievance_type_id', $grievanceType->id)
                ->screenshot('screenshot-create-grievance-detail-page')
            ;
            $browser
                ->pause(5000)
                ->press('Save')
                ->waitForLocation(route('admin.grievance.grievanceDetail.index'), 5) // ⏳ Wait for redirect
                ->assertUrlIs(route('admin.grievance.grievanceDetail.index'));
            $browser->screenshot('screenshot-create-grievance-page');
        });
    }
}
