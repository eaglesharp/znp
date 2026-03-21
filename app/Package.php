<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    protected $table = 'packages';
    protected $fillable = [
        'normal_cv_access', 'verified_cv_access'
    ];
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
