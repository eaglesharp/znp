<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\User;
use Carbon\Carbon;

class sendMailDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:mail_send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an daily email to all the users';

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
        $today = Carbon::now();
        $tomorow = Carbon::now()->add(1, 'day');;
        
     
        if($today == $tomorow)
        {
            $user = User::all();
            foreach ($user as $a)
            {
            Mail::raw("This is automatically generated daily Update", function($message) use ($a)
            {
            $message->from('phpflow@gmail.com');
            $message->to($a->email)->subject('Daily Update');
            });
            }
            $this->info('Daily Update mails has been send successfully');
        }

         
    }
}
