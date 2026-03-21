<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Company;

class AlertKYC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:kyc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kyc Alert Notification';

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

        \App\Company::whereDate('package_start_date', '<=', Carbon::now()->addDays(5))
        ->update(['is_freeze' => 0]);


    }
}
