<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Models\WateringEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessIrrigationSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'irrigation:process-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all irrigation schedules and start watering for due schedules';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Processing irrigation schedules...');

        $now = Carbon::now();
        $currentDayOfWeek = $now->format('l'); // Returns day name (Monday, Tuesday, etc.)
        $currentTime = $now->format('H:i:00');

        $dueSchedules = Schedule::whereJsonContains('days_of_week', $currentDayOfWeek)
            ->where('start_time', $currentTime)
            ->with('zone')
            ->get();

        $this->info("Found {$dueSchedules->count()} schedules due for watering.");

        foreach ($dueSchedules as $schedule) {
            $this->processSchedule($schedule);
        }

        $this->info('Irrigation schedules processed successfully.');
        return 0;
    }

    /**
     * Process a single schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function processSchedule(Schedule $schedule)
    {
        $zone = $schedule->zone;

        // Check if zone is already being watered
        $activeEvent = $zone->wateringEvents()
            ->where('status', 'in_progress')
            ->first();

        if ($activeEvent) {
            $this->warn("Zone {$zone->name} is already being watered. Skipping scheduled watering.");
            return;
        }

        // Parse duration (assuming format like "30 minutes" or "1 hour")
        $durationParts = explode(' ', $schedule->duration);
        $durationValue = (int) $durationParts[0];
        $durationUnit = $durationParts[1] ?? 'minutes';

        // Calculate end time
        $startTime = Carbon::now();
        $endTime = $startTime->copy();

        if (str_contains($durationUnit, 'hour')) {
            $endTime->addHours($durationValue);
        } else {
            $endTime->addMinutes($durationValue);
        }

        // Create watering event
        WateringEvent::create([
            'zone_id' => $zone->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'in_progress',
        ]);

        $this->info("Started watering for zone {$zone->name} with duration {$schedule->duration}");
    }
}
