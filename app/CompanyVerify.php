<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyVerify extends Model
{
    protected $fillable = [
        'company_id',
        'token',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
