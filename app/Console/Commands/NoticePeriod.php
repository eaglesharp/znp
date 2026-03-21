<?php

namespace App\Console\Commands;

use App\User;
use App\ProfileNop;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class NoticePeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noticeperiod:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notice Period Status Update';

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
       
        $users=\App\ProfileNop::whereDate('last_working_day','<',Carbon::now())->get();
     //  dd($users);
        foreach ($users as $user)
            {
                

                $user->nop_days = 1;
                $user->save();
                
      
            }
    }
}
