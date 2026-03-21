<?php



namespace App\Exports;



use App\JobSkill;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;



class JobSkillsExport implements FromView

{

    public function view(): View

    {

        // return dd($this->id);

       

        $jobskills = JobSkill::all();

        // return dd($states);

        return view('admin.exports.jobskills', [

            'jobskills' => $jobskills,

        ]);



      

    }

}

