<?php

namespace App\Imports;

use App\User;
use App\ProfileSummary;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Carbon\Carbon;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EducationImport implements WithMultipleSheets 
{


    public function sheets(): array
    {
        return [
            new EducationsImport()
        ];
    }

    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
 
  
}