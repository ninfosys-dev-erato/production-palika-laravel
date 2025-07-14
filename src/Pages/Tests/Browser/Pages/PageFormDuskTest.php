<?php

namespace Src\Pages\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Src\Pages\Models\Page;
use Src\Pages\Tests\TestData\PageForm_TestData;
use App\Models\User;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class PageFormDuskTest extends DuskTestCase
{
    #[Test]
    public function it_can_submit_form_with_valid_data()
    {
        $this->browse(function (Browser $browser) {
            $data = PageForm_TestData::validData();
            $fieldSelectors = require base_path('src/Pages/Tests/metadata.php');

            $browser->loginAs(User::find(1))
                ->visit(route('admin.pages.create'));

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
                ->waitForLocation(route('admin.pages.index'), 5)
                ->assertUrlIs(route('admin.pages.index'));
        });
    }

    #[Test]
    public function it_shows_validation_errors()
    {
        $this->browse(function (Browser $browser) {
            $data = PageForm_TestData::invalidData();
            $fieldSelectors = require base_path('src/Pages/Tests/metadata.php');

            $browser->loginAs(User::find(1))
                ->visit(route('admin.pages.create'));

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
            $browser->assertSee(__('The slug field is required.'));
            $browser->assertSee(__('The slug must be unique.'));
            $browser->assertSee(__('pages::pages.title_is_required'));
            $browser->assertSee(__('pages::pages.content_is_required'));
        });
    }

    #[Test]
    public function it_can_edit_and_update_page()
    {
        $page = Page::factory()->create();
        $data = PageForm_TestData::validData();
        $fieldSelectors = require base_path('src/Pages/Tests/metadata.php');
        $user = User::find(1);
        $user->givePermissionTo('pages edit');

        $this->browse(function (Browser $browser) use ($page, $data, $fieldSelectors, $user) {
            $browser->loginAs($user)
                ->visit(route('admin.pages.edit', ['id' => $page->id]));

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
                ->waitForLocation(route('admin.pages.index'), 5)
                ->assertUrlIs(route('admin.pages.index'));
        });
    }

    #[Test]
    public function it_can_delete_page_from_index_table()
    {
        $page = Page::factory()->create(['id' => 1001]);
        $user = User::find(1);
        $user->givePermissionTo('pages delete');

        $this->browse(function (Browser $browser) use ($page, $user) {
            $browser->loginAs($user)
                ->visit(route('admin.pages.index'))
                ->waitFor('table')
                ->assertSeeIn('table', $page->id)
                ->click('button[wire\:confirm][wire\:click="delete('.$page->id.')"]')
                ->waitForDialog()
                ->acceptDialog()
                ->waitForText('Page deleted successfully')
                ->assertDontSeeIn('table', $page->id);
        });
    }

    #[Test]
    public function delete_button_hidden_for_unauthorized_users()
    {
        $page = Page::factory()->create();
        $user = User::find(1);
        $user->revokePermissionTo('pages delete');

        $this->browse(function (Browser $browser) use ($page, $user) {
            $browser->loginAs($user)
                ->visit(route('admin.pages.index'))
                ->waitFor('table')
                ->assertNotPresent('button[wire\:confirm][wire\:click="delete('.$page->id.')"]');
        });
    }
}
