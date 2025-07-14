<?php

namespace Src\Recommendation\Tests\Browser\RecommendationCategory;

use App\Models\User;
use Database\Factories\RecommendationCategoryFactory;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\TestHelper;
use Tests\DuskTestCase;

class CreateRecommendationCategoryTest extends DuskTestCase
{
    use TestHelper;
    public function test_user_can_create_recommendation_catgeory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(route('admin.recommendations.recommendation-category.create'))
                ->type('@title', 'Test Recommendation Category');
           
            $browser->press('Save')
                ->waitForLocation(route('admin.recommendations.recommendation-category.index'), 5) // ⏳ Wait for redirect
                ->assertUrlIs(route('admin.recommendations.recommendation-category.index'));
            $browser->screenshot('screenshot-create-recommendation-category');
        });
    }

    public function test_requires_recommendation_category_title_field()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit(route('admin.recommendations.recommendation-category.create'))
                ->pause(5000)
                ->press('Save')
                ->pause(5000)
                ->waitForText('The title is required.')
                ->assertSee('The title is required.')
                ->screenshot('recommendation1_category_validation-shown');
        });
    }

}
