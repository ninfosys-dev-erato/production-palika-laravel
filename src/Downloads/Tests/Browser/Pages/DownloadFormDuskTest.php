<?php

namespace Src\Downloads\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Src\Downloads\Tests\TestData\DownloadForm_TestData;
use App\Models\User;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class DownloadFormDuskTest extends DuskTestCase
{
    #[Test]
    public function it_can_submit_form_with_valid_data()
    {
        $this->browse(function (Browser $browser) {
            $data = DownloadForm_TestData::validData();
            $fieldSelectors = require base_path('src/Downloads/Tests/metadata.php');

            $browser->loginAs(User::find(1))
                ->visit(route('admin.downloads.create'));

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
                ->waitForLocation(route('admin.downloads.index'), 5)
                ->assertUrlIs(route('admin.downloads.index'));
        });
    }

    #[Test]
    public function it_shows_validation_errors()
    {
        $this->browse(function (Browser $browser) {
            $data = DownloadForm_TestData::invalidData();
            $fieldSelectors = require base_path('src/Downloads/Tests/metadata.php');

            $browser->loginAs(User::find(1))
                ->visit(route('admin.downloads.create'));

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
            $browser->assertSee(__('downloads::downloads.the_title_is_required.'));
            $browser->assertSee(__('downloads::downloads.the_english_title_is_required.'));
            $browser->assertSee(__('downloads::downloads.each_file_must_be_a_valid_file.'));
            $browser->assertSee(__('downloads::downloads.the_file_must_be_a_pdf,_doc,_docx,_jpg,_jpeg,_or_png.'));
            $browser->assertSee(__('downloads::downloads.the_file_must_not_exceed_2mb_in_size.'));
            $browser->assertSee(__('downloads::downloads.the_status_is_required.'));
            $browser->assertSee(__('downloads::downloads.the_order_is_required.'));
        });
    }
}
