<?php

namespace Src\Recommendation\Tests\Browser\Recommendation;

use App\Models\User;
use Database\Factories\FormFactory;
use Database\Factories\RecommendationCategoryFactory;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\TestHelper;
use Tests\DuskTestCase;

class CreateRecommendationTest extends DuskTestCase
{
    use TestHelper;

    public function test_user_can_create_recommendation()
    {
        $user = User::find(1);

        $category = RecommendationCategoryFactory::new()->create([
            'title' => 'Test Recommendation Category',
        ]);

        $form = FormFactory::new()->create([
            'module' => \Src\Settings\Enums\ModuleEnum::RECOMMENDATION->value,
        ]);

        $this->browse(function (Browser $browser) use ($user, $category, $form) {
            $browser->loginAs($user)
                ->visit(route('admin.recommendations.recommendation-category.create'))
                ->type('@title', 'Test Recommendation')
                ->select('@recommendation-initialRecommendation.recommendation_category_id-field', $category->id)
                ->select('@recommendation-initialRecommendation.form_id-field', $form->id)
                ->type('@revenue', '500')
                ->check('@is_ward_recommendation')
                ->screenshot('screenshot-before-create-recommendation');

            $browser->waitForAlert()
                    ->acceptAlert();

            $browser->press('Next');

            $browser->screenshot('screenshot-create-recommendation');
        });
    }
}
