<?php

namespace Src\Recommendation\Tests\Browser\Components;

use App\Models\User;
use Database\Factories\FormFactory;
use Laravel\Dusk\Browser;
use Src\Recommendation\Database\Factories\RecommendationCategoryFactory;
use Src\Recommendation\Database\Factories\RecommendationFactory;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Settings\Enums\ModuleEnum;
use Tests\DuskTestCase;
use Src\Pages\Models\Page;

class RecommendationTableTest extends DuskTestCase
{
    public function test_datatable_shows_recommendation()
    {
        $user = User::find(1);
        $category = RecommendationCategoryFactory::new()->create([
            'title' => 'Test Recommendation Type',
        ]);
        $form = FormFactory::new()->create([
            'module' => ModuleEnum::RECOMMENDATION->value,
        ]);
        RecommendationFactory::new()->create([
            'title' => 'Test Recommendation',
            'recommendation_category_id' => $category->id,
            'form_id' => $form->id,
            'created_by' => $user->id,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/recommendations/recommendation')
                ->assertSee('Test Recommendation');
        });  
    }
}
