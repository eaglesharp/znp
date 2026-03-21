<?php

namespace App\Exports;

use App\Country;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CountryExport implements FromView
{
     
    public function view(): View
    {
        // return dd($this->id);
       
        $country = Country::where('lang','en')->orderBy('sort_order', 'ASC')->get();
        // return dd($states);
        return view('admin.exports.country', [
            'country' => $country,
        ]);
    }
}
