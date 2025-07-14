<?php

namespace Src\Pages\Tests\Browser\Components;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Src\Pages\Models\Page;

class PageTableTest extends DuskTestCase
{

    public function test_datatable_shows_pages()
    {
        Page::factory()->create(['title' => 'Dusk Page']);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/pages')
                ->assertSee('Dusk Page');
        });
    }
}
