<?php

namespace Src\Downloads\Tests\Feature;

use App\Enums\Action;
use Livewire\Livewire;
use App\Models\User;
use Src\Downloads\Models\Download;
use Src\Downloads\Livewire\DownloadForm;
use Src\Downloads\Tests\TestData\DownloadForm_TestData;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DownloadFormTest extends TestCase
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
        $this->get(route('admin.downloads.create'))->assertSeeLivewire(DownloadForm::class);
    }

    #[Test]
    public function it_validates_download_order_is_required()
    {
        Livewire::test(DownloadForm::class,[
            'downloads' => new Download(),
            'action' => Action::CREATE
        ])
            ->set('download.order', '')
            ->call('save')
            ->assertHasErrors('download.order')
            ->assertSee(__('downloads::downloads.the_order_is_required.'));
    }

    #[Test]
    public function it_validates_download_status_is_required()
    {
        Livewire::test(DownloadForm::class,[
            'downloads' => new Download(),
            'action' => Action::CREATE
        ])
            ->set('download.status', '')
            ->call('save')
            ->assertHasErrors('download.status')
            ->assertSee(__('downloads::downloads.the_status_is_required.'));
    }

    #[Test]
    public function it_validates_download_title_is_required()
    {
        Livewire::test(DownloadForm::class,[
            'downloads' => new Download(),
            'action' => Action::CREATE
        ])
            ->set('download.title', '')
            ->call('save')
            ->assertHasErrors('download.title')
            ->assertSee(__('downloads::downloads.the_title_is_required.'));
    }

    #[Test]
    public function it_validates_download_title_en_is_required()
    {
        Livewire::test(DownloadForm::class,[
            'downloads' => new Download(),
            'action' => Action::CREATE
        ])
            ->set('download.title_en', '')
            ->call('save')
            ->assertHasErrors('download.title_en')
            ->assertSee(__('downloads::downloads.the_english_title_is_required.'));
    }

    #[Test]
    public function it_validates_files_is_required()
    {
        Livewire::test(DownloadForm::class,[
            'downloads' => new Download(),
            'action' => Action::CREATE
        ])
            ->set('files', '')
            ->call('save')
            ->assertHasErrors('files')
            ;
    }

    #[Test]   
    public function it_can_save_with_valid_data()
    {
        $testData = DownloadForm_TestData::validData();


        Livewire::test(DownloadForm::class,[
         'downloads'=> new Download(),
         'action'=> Action::CREATE
])
            ->set('download.order', $testData['order'] ?? '')
            ->set('download.status', $testData['status'] ?? '')
            ->set('download.title', $testData['title'] ?? '')
            ->set('download.title_en', $testData['title_en'] ?? '')
            ->set('files', $testData['files'] ?? '')
            ->call('save')
            ->assertHasNoErrors();
    }
}
