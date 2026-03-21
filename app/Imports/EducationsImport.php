<?php

namespace App\Imports;

use App\User;
use App\ProfileSummary;
use App\ProfileExperience;
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
use App\Degree;
use App\CompanyData;



class EducationsImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements ToCollection, WithHeadingRow,WithCustomValueBinder 
{
  
    
    public function collection(Collection $rows)
    {
        //  $password = 'required|min:6';
         Validator::make($rows->toArray(), [
          

             '*.name' => 'required',
           
          
  
         ])->validate();
            // return dd($rows);
        foreach ($rows as $row) {
            $user = new CompanyData();
            $user->name= $row['name']; 
            $user->save();
        }
        
    }
}