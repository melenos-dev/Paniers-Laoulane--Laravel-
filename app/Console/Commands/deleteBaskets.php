<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Basket;
use Carbon\Carbon;

class deleteBaskets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'baskets:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete baskets at midnight if they are older than 2 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Basket::where('created_at', '<', Carbon::now())->each(function ($basket) {
            $actual_start_at = Carbon::parse($basket->created_at);
            $actual_end_at   = Carbon::parse(Carbon::now());
            $mins            = $actual_end_at->diffInMinutes($actual_start_at, true);
            if($mins > 120)
                $basket->delete();
        });
    }
}
