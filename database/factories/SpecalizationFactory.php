<?php

namespace Database\Factories;

use App\Models\Specalization;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProgramName;

class SpecalizationFactory extends Factory
{
    protected $model = Specalization::class;

    public function definition()
    {
        return [
            'program_name_id' => ProgramName::inRandomOrder()->first()?->id ?? ProgramName::factory(),
            'code' => $this->faker->unique()->numerify('SPC###'),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'is_visible' => true,
        ];
    }
} 