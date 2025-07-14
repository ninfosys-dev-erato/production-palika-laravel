<?php

namespace Src\Pages\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Src\Pages\Models\Page;
use Src\Pages\DTO\PageAdminDto;
use Src\Pages\Service\PageAdminService;

class PageAdminServiceTest extends TestCase
{
    public function test_it_can_create_a_page()
    {
        $dto = new PageAdminDto(
            slug: "test-page-service",
            title: 'Test Page Service',
            content: 'This is a test page',
        );

        $service = new PageAdminService();
        $page = $service->store($dto);

        $this->assertDatabaseHas('tbl_pages', [
            'title' => 'Test Page Service',
            'slug' => 'test-page-service',
        ]);
    }

    public function test_it_can_update_a_page()
    {
        $page = Page::factory()->create();

        $dto = new PageAdminDto(
            slug: "updated-title",
            title: 'Updated Title',
            content: 'This is a test page',
        );

        $service = new PageAdminService();
        $updatedPage = $service->update($page, $dto);

        $this->assertEquals('Updated Title', $updatedPage->title);
        $this->assertDatabaseHas('tbl_pages', ['slug' => 'updated-title']);
    }
}
