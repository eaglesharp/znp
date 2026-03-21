<?php



namespace App\Exports;



use App\Course;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;



class DegreeTypeExport implements FromView

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function view(): View

    {

        // return dd($this->id);

       

        $course = Course::all();

        // return dd($states);

        return view('admin.exports.degreetype', [

            'course' => $course,

        ]);



      

    }

}

