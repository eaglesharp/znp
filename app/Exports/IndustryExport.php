<?php



namespace App\Exports;



use App\specs;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;



class IndustryExport implements FromView

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function view(): View

    {

        // return dd($this->id);

       

        $specs = specs::all();

        // return dd($states);

        return view('admin.exports.industry', [

            'specs' => $specs,

        ]);



      

    }

}

