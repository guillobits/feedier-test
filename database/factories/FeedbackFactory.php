<?php

namespace Database\Factories;

use App\Enum\FeedbackSourceEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'email' => $this->faker->unique()->safeEmail,
            'source' => $this->faker->randomElement([
                FeedbackSourceEnum::DASHBOARD,
                FeedbackSourceEnum::EXTERNAL
            ]),
        ];
    }
}
