<?php

namespace Src\Pages\Tests\Browser\Pages;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\TestHelper;
use Tests\DuskTestCase;

class GrievanceTypePage extends DuskTestCase
{
    use TestHelper;
    public function test_user_can_create_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(route('admin.pages.create'))
                ->type('@title', 'Test Page')
                ->type('@slug', 'test-page')
            ;
            $browser->waitFor('.ck-editor__editable', 10)  // Wait for CKEditor container to be visible
                ->within('.ck-editor__editable', function ($browser) {
                    $browser->type('p', 'Your new content');  // Type into the <p> element
                });

            $browser->press('Save')
                ->waitForLocation(route('admin.pages.index'), 5) // ⏳ Wait for redirect
                ->assertUrlIs(route('admin.pages.index'));
            $browser->screenshot('screenshot-create-page');
        });
    }
}
