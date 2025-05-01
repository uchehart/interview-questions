<?php

namespace Database\Factories;

use App\Models\Zone;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $selectedDays = $this->faker->randomElements($days, $this->faker->numberBetween(1, 7));

        return [
            'zone_id' => Zone::factory(),
            'start_time' => $this->faker->time('H:i'),
            'duration' => $this->faker->numberBetween(15, 120) . ' minutes',
            'days_of_week' => $selectedDays,
        ];
    }
}