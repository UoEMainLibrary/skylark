<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

#[Signature('app:schedule-heartbeat')]
#[Description('Write a heartbeat line to the schedule log (confirms cron is running schedule:run)')]
class ScheduleHeartbeat extends Command
{
    public function handle(): int
    {
        Log::channel('schedule')->info('Scheduler heartbeat', [
            'host' => gethostname() ?: null,
            'environment' => app()->environment(),
            'application' => config('app.name'),
        ]);

        $this->components->info('Scheduler heartbeat logged to storage/logs/schedule.log');

        return self::SUCCESS;
    }
}
