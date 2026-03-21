<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $fillable=['user_id','hold','expoff','repoff','ctcoff','dateoff','locoff','ctcoff1','dateoff1','locoff1'];
}
