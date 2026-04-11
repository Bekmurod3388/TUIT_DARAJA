<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicYearFactory extends Factory
{
    protected $model = AcademicYear::class;

    public function definition(): array
    {
        $startYear = $this->faker->numberBetween(2024, 2030);

        return [
            'name' => $startYear . '/' . ($startYear + 1),
            'semester' => $this->faker->randomElement(AcademicYear::SEMESTERS),
            'is_active' => false,
        ];
    }
}
