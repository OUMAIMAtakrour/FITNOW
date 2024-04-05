<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Progress;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Progress>
 */
class ProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
           'user_id'=>4,
            'weight'=>fake()->numerify(),
            'waist'=>fake()->numerify(),
            'abs'=>fake()->numerify(),
           
         
        ];
    }
}
