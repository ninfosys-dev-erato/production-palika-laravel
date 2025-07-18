<?php

namespace Src\Pages\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Pages\Models\Page;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'content' => $this->faker->randomHtml,
        ];
    }
}
