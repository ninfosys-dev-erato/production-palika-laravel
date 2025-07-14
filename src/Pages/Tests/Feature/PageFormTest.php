<?php

namespace Src\Pages\Tests\Feature;

use App\Enums\Action;
use Livewire\Livewire;
use App\Models\User;
use Src\Pages\Models\Page;
use Src\Pages\Livewire\PageForm;
use Src\Pages\Tests\TestData\PageForm_TestData;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PageFormTest extends TestCase
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
        $this->get(route('admin.pages.create'))->assertSeeLivewire(PageForm::class);
    }

    #[Test]
    public function it_validates_page_slug_is_required()
    {
        Livewire::test(PageForm::class,[
            'pages' => new Page(),
            'action' => Action::CREATE
        ])
            ->set('page.slug', '')
            ->call('save')
            ->assertHasErrors('page.slug')
            ->assertSee(__('The slug field is required.'));
    }

    #[Test]
    public function it_validates_page_title_is_required()
    {
        Livewire::test(PageForm::class,[
            'pages' => new Page(),
            'action' => Action::CREATE
        ])
            ->set('page.title', '')
            ->call('save')
            ->assertHasErrors('page.title')
            ->assertSee(__('pages::pages.title_is_required'));
    }

    #[Test]   
    public function it_can_call_cleanHtml()
    {
        Livewire::test(PageForm::class,[
         'pages'=> new Page(),
         'action'=> Action::CREATE
])
            ->call('cleanHtml')
            ->assertNotDispatchedBrowserEvent('cleanHtml-failed');
    }

    #[Test]   
    public function it_can_save_with_valid_data()
    {
        $testData = PageForm_TestData::validData();


        Livewire::test(PageForm::class,[
         'pages'=> new Page(),
         'action'=> Action::CREATE
])
            ->set('page.slug', $testData['slug'] ?? '')
            ->set('page.title', $testData['title'] ?? '')
            ->call('save')
            ->assertHasNoErrors();
    }
}
