<?php

namespace App\Console\Commands;

use App\Models\WateringEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckWateringEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'irrigation:check-watering-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check active watering events and mark completed ones';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking active watering events...');

        $now = Carbon::now();

        $activeEvents = WateringEvent::where('status', 'in_progress')
            ->where('end_time', '<=', $now)
            ->with('zone')
            ->get();

        $this->info("Found {$activeEvents->count()} watering events to complete.");

        foreach ($activeEvents as $event) {
            $event->status = 'completed';
            $event->save();

            $this->info("Completed watering for zone {$event->zone->name}");
        }

        $this->info('Watering events checked successfully.');
        return 0;
    }
}
