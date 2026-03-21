<?php

namespace App\Traits;

trait Status
{

    public function scopeStatus($query)
    {
        return $query->where('status', '=', 1);
    }

}
