<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeySkill extends Model
{
    use \Conner\Tagging\Taggable;
    
    protected $fillable=['user_id','keyskill'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
