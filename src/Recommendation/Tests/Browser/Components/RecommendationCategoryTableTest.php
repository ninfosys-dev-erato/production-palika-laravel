<?php

namespace Src\Recommendation\Tests\Browser\Components;

use App\Models\User;
use Database\Factories\FormFactory;
use Database\Factories\RecommendationFactory;
use Laravel\Dusk\Browser;
use Src\Recommendation\Database\Factories\RecommendationCategoryFactory;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Settings\Enums\ModuleEnum;
use Tests\DuskTestCase;
use Src\Pages\Models\Page;

class RecommendationCategoryTableTest extends DuskTestCase
{
    public function test_datatable_shows_recommendation_category()
    {
        RecommendationCategoryFactory::new()->create([
            'title' => 'Test Recommendation Type',
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/recommendations/recommendation-category')
                ->assertSee('Test Recommendation Type');
        });
    }
}
