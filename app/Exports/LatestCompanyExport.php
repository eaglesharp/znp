<?php



namespace App\Exports;



use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use DB;



class LatestCompanyExport implements FromView

{

    public function view(): View

    {

        // return dd($this->id);

       

        $companies = DB::table('company_data')->select('id','name')->distinct()->get();

        // return dd($states);

        return view('admin.exports.latestcompany', [

            'companies' => $companies,

        ]);



      

    }

}

