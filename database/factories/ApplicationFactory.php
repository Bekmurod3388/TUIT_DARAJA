<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use App\Models\Specalization;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        $specalization = Specalization::factory();

        return [
            'user_id' => User::factory(),
            'specalization_id' => $specalization,
            'academic_year_id' => function (array $attributes) {
                return Specalization::query()->whereKey($attributes['specalization_id'])->value('academic_year_id');
            },
            'organization' => $this->faker->company(),
            'subject' => $this->faker->word(),
            'status' => 'pending',
            'payment_status' => 'pending',
        ];
    }
} 
