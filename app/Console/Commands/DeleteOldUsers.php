<?php

namespace App\Console\Commands;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class DeleteOldUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users 30 days old';

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
        $user = User::whereDate('package_end_date',Carbon::now()->subDays(5))->get();
        // dd($user);
        foreach ($user as $a)
            {
            Mail::raw("This is automatically generated daily Update", function($message) use ($a)
            {
            $message->from('jayabharathi.nexevo@gamil.com');
            $message->to($a->email)->subject('Daily Update');
            });
            }
    }
}
