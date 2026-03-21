<?php

namespace App\Console\Commands;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ReminderMailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder Mail Send For the Users';

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
        $user = User::whereDate('package_end_date',Carbon::now()->addDays(5))->get();
       // dd($user);
        foreach ($user as $a)
            {
                
                $data = [
                'name'=> $a->first_name,
                'email' => $a->email,                
                'mobile' => '1234'
            ];
            Mail::send('emails.subscription_reminder_users',$data,function($message) use ($a)
            {
            $message->from('info@zeronoticeperiod.com');
            $message->to($a->email)->subject('Plan Expired Soon');
            });
            }
    }
}
