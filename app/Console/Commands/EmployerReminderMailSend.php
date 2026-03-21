<?php

namespace App\Console\Commands;
use App\Company;
use App\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class EmployerReminderMailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employerreminder:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder Mail Send For the Employers';

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
        $employers = Company::whereDate('package_end_date',Carbon::now()->addDays(5))->get();
         // dd($employers);
        foreach ($employers as $a)
            {

                $package = Package::where('id',$a->package_id)->first();
                
                $data = [
                'name'=> $a->name,
                'email' => $a->email,                
                'plan' => $package->package_title,
                'end_date' => $a->package_end_date
            ];
            Mail::send('emails.subscription_reminder_employers',$data,function($message) use ($a)
            {
            $message->from('info@zeronoticeperiod.com');
            $message->to($a->email)->subject('Plan Expired Soon');
            });
            }
    }
}
