<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable=[
    
    
       'cerificate_name','certificate_agency','year_of_passing','month_of_passing','duration'
        
        ];
        
        protected $table = 'certificates';
        public $timestamps = true;
        protected $guarded = ['id'];
        //protected $dateFormat = 'U';
        protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];
    
        public function certificates()
        {
            return $this->belongsTo('App\Certificate', 'user_id', 'id');
        }
    
        public function getUser($field = '')
        {
            if (null !== $user = $this->user()->first()) {
                if (empty($field))
                    return $user;
                else
                    return $user->$field;
            } else {
                return '';
            }
}
}