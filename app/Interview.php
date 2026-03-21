<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected  $fillable = ['user_id','from_time','to_time','date'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
