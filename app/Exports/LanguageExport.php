<?php



namespace App\Exports;



use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;



class LanguageExport implements FromView

{

    public function view(): View

    {

        // return dd($this->id);

       

        $languages = User::all();

        // return dd($states);

        return view('admin.exports.languages', [

            'languages' => $languages,

        ]);



      

    }

}

