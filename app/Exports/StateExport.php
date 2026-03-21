<?php

namespace App\Exports;

use App\State;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StateExport implements FromView
{
   
    public function view(): View
    {
        // return dd($this->id);
       
       $users = User::all()->take(2);
        // return dd($states);
        return view('admin.exports.state', [
             'users' => $users,
        ]);
    }
}
