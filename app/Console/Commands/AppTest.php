<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\RideController;
use App\Models\Ride;
use Illuminate\Console\Command;

class AppTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(RideController $rideController)
    {
        dd(
            $rideController->ridePrices(Ride::find(81))
        );
    }
}
