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
        return [
            'user_id' => User::factory(),
            'specalization_id' => Specalization::factory(),
            'organization' => $this->faker->company(),
            'subject' => $this->faker->word(),
            'status' => 'pending',
            'payment_status' => 'pending',
        ];
    }
} 