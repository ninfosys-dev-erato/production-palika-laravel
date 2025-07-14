<?php

namespace Src\Pages\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Src\Pages\Models\Page;
use Tests\TestCase;

class PageTableTest extends TestCase
{
    public function test_it_shows_data_in_table()
    {
        Page::factory()->create(['title' => 'Example Page']);

        Livewire::test(\Src\Pages\Livewire\PageTable::class)
            ->assertSee('Example Page');
    }
}
