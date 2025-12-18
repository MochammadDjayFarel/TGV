<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create test tickets
$flight_schedule_ids = \Illuminate\Support\Facades\DB::table('flight_schedules')->pluck('id')->toArray();

if (!empty($flight_schedule_ids)) {
    for ($i = 1; $i <= 5; $i++) {
        \App\Models\Ticket::create([
            'reservation_code' => 'RES' . str_pad($i, 5, '0', STR_PAD_LEFT),
            'img' => null,
            'flight_schedule_id' => $flight_schedule_ids[array_rand($flight_schedule_ids)]
        ]);
    }
    echo "Created 5 test tickets\n";
} else {
    echo "No flight schedules found\n";
}
