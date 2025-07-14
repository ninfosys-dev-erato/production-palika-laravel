<?php

namespace Src\Wards\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Src\Wards\Database\Factories\WardFactory;
use Src\Wards\Models\Ward;
use Src\Wards\Tests\TestData\WardForm_TestData;
use App\Models\User;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class WardFormDuskTest extends DuskTestCase
{
    #[Test]
    public function it_can_submit_form_with_valid_data()
    {
        $this->browse(function (Browser $browser) {
            $data = WardForm_TestData::validData();
            $fieldSelectors = require base_path('src/Wards/Tests/metadata.php');

            $browser->loginAs(User::find(1))
                ->visit(route('admin.wards.create'));

            foreach ($data as $key => $value) {
                $duskSelector = $fieldSelectors[$key] ?? null;
                if ($duskSelector) {
                    if (is_array($value)) {
                        $browser->select('@' . $duskSelector, $value['id'] ?? $value[0]);
                    } else {
                        $browser->type('@' . $duskSelector, $value);
                    }
                }
            }


            $browser->press('Save')
                ->waitForLocation(route('admin.wards.index'), 5)
                ->assertUrlIs(route('admin.wards.index'));
        });
    }

    #[Test]
    public function it_shows_validation_errors()
    {
        $this->browse(function (Browser $browser) {
            $data = WardForm_TestData::invalidData();
            $fieldSelectors = require base_path('src/Wards/Tests/metadata.php');

            $browser->loginAs(User::find(1))
                ->visit(route('admin.wards.create'));

            foreach ($data as $key => $value) {
                $duskSelector = $fieldSelectors[$key] ?? null;
                if ($duskSelector) {
                    if (is_array($value)) {
                        $browser->select('@' . $duskSelector, $value['id'] ?? $value[0]);
                    } else {
                        $browser->type('@' . $duskSelector, $value);
                    }
                }
            }

            $browser->press('Save');
            $browser->pause(1500);
            $browser->screenshot('validation-errors');
            $browser->assertSee(__('wards::wards.phone_is_required'));
            $browser->assertSee(__('wards::wards.email_is_required'));
            $browser->assertSee(__('wards::wards.address_en_is_required'));
            $browser->assertSee(__('wards::wards.address_ne_is_required'));
            $browser->assertSee(__('wards::wards.ward_name_en_is_required'));
            $browser->assertSee(__('wards::wards.ward_name_ne_is_required'));
        });
    }

    #[Test]
    public function it_can_edit_and_update_ward()
    {
        // Create a ward with specific testable values
        $ward = Ward::factory()->create([
            'ward_name_en' => 'Original Name',
            'phone' => '1234567890'
        ]);
        $user = User::find(1);
        $user->givePermissionTo('wards edit');

        $this->browse(function (Browser $browser) use ($ward, $user) {
            dump($ward); //
            // Navigate to edit page directly (bypassing table click for reliability)
            $browser->loginAs($user)
                ->visit(route('admin.wards.edit', ['id'=>$ward->id]))
                ->assertInputValue('ward_name_en', 'Original Name')
                ->assertInputValue('phone', '1234567890');
            $browser->screenshot('editpage-reached');

            // Clear and update fields
            $browser->type('ward_name_en', '')
                ->type('ward_name_en', 'Updated Ward Name') // Clear and set new value
                ->type('phone', '9876543210');
            $browser->screenshot('editpage-done saved');
            $browser->press('Save')
                ->waitForLocation(route('admin.wards.index'), 5)
                ->assertUrlIs(route('admin.wards.index'))
                ->assertSee('Updated Ward Name')
            ;
        });
    }

    #[Test]
    public function it_can_delete_ward_from_index_table()
    {
        $ward = Ward::factory()->create(['ward_name_en' => 'To Be Deleted']);
        $user = User::find(1);
        $user->givePermissionTo('wards delete');

        $this->browse(function (Browser $browser) use ($ward, $user) {
            $browser->loginAs($user)
                ->visit(route('admin.wards.index'))
                ->waitFor('table')
                ->assertSeeIn('table', 'To Be Deleted')
                ->click('button[wire\\:confirm][wire\\:click="delete('.$ward->id.')"]')
                ->waitForDialog()
                ->acceptDialog()
                ->waitForText('Ward deleted successfully')
                ->assertDontSeeIn('table', 'To Be Deleted');
        });
    }

    #[Test]
    public function delete_button_hidden_for_unauthorized_users()
    {
        $ward = Ward::factory()->create();
        $user = User::find(1);
        $user->revokePermissionTo('wards delete');

        $this->browse(function (Browser $browser) use ($ward, $user) {
            $browser->loginAs($user)
                ->visit(route('admin.wards.index'))
                ->waitFor('table')
                ->assertNotPresent('button[wire\\:confirm][wire\\:click="delete('.$ward->id.')"]');
        });
    }
}
