<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'chassis_series' => $this->faker->unique()->word,
            'manufacture_year' => $this->faker->year,
            'engine' => $this->faker->word,
        ];
    }
}