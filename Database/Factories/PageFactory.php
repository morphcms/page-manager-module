<?php

namespace Modules\PageManager\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PageManager\Enums\PageStatus;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\PageManager\Models\Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(random_int(2, 4), asText: true),
            'summary' => $this->faker->paragraph,
        ];
    }

    public function review(): PageFactory
    {
        return $this->state([
            'status' => PageStatus::Review,
        ]);
    }

    public function published(): PageFactory
    {
        return $this->state([
            'status' => PageStatus::Published,
        ]);
    }
}
