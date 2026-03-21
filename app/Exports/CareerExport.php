<?php

namespace App\Exports;

use App\CareerLevel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CareerExport implements FromView
{
   
    public function view(): View
    {
        // return dd($this->id);
       
        $career = CareerLevel::where('lang','en')->orderBy('sort_order', 'ASC')->get();
        // return dd($states);
        return view('admin.exports.career', [
            'career' => $career,
        ]);
    }
}
