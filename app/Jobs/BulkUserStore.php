<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Certificate;
use App\Course;
use App\Offers;
use App\User;
use App\KeySkill;
use App\JobSkill;
use App\ProfileSummary;
use App\ProfileExperience;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Carbon\Carbon;
use App\ProfileProject;
use App\ProfileEducation;
use App\ProfileSkill;
use App\ProfileLanguage;
use App\ProfileNop;
use App\ProfileGap;
use App\ProfileCityJobsCity;
use App\ProfileDetails;
use Mail;
use App\Events\UserRegistered;
use App\Mail\NewUserRegistered;
use Illuminate\Support\Str;
use App\CompanyData;

class BulkUserStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


     public $rows;


    public function __construct($rows)
    {
               $this->rows = $rows;
    }

    public function dbdatechange($date)

    {

    $date= date("Y-m-d", strtotime($date));

    return $date;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       // dd('test');

    }
}
