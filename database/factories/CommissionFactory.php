<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Specalization;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    public function definition()
    {
        return [
            'specalization_id' => Specalization::factory(),
            'chairman' => $this->faker->name(),
            'deputy' => $this->faker->name(),
            'secretary' => $this->faker->name(),
            'members' => json_encode([
                $this->faker->name(),
                $this->faker->name(),
                $this->faker->name(),
            ]),
        ];
    }
} 