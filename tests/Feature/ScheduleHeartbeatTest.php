<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

it('logs a scheduler heartbeat to storage/logs/schedule.log', function (): void {
    $logPath = storage_path('logs/schedule.log');

    if (is_file($logPath)) {
        unlink($logPath);
    }

    Artisan::call('app:schedule-heartbeat');

    expect(Artisan::output())->toContain('Scheduler heartbeat logged')
        ->and(is_file($logPath))->toBeTrue()
        ->and(file_get_contents($logPath))->toContain('Scheduler heartbeat');
});

it('registers the heartbeat on the hourly schedule', function (): void {
    $events = app(Schedule::class)->events();

    $heartbeat = collect($events)->first(
        fn ($event) => str_contains($event->command ?? '', 'app:schedule-heartbeat')
    );

    expect($heartbeat)->not->toBeNull()
        ->and($heartbeat->expression)->toBe('0 * * * *');
});
