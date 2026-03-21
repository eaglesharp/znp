<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class sendWeeklyReport extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'weekly:mail_report';
   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Weekly report send to Manager';
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
    $a = User::latest()->take(2);
   
    Mail::raw("This is automatically generated daily Update", function($message) use ($a)
    {
    $message->from('phpflow@gmail.com');
    $message->to($a->email)->subject('Daily Update');
    });
    
    $this->info('Daily Update mails has been send successfully');
    Log::info("Cron is working fine!");
   }
}