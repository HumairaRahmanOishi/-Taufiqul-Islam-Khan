<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function albumInfo()
    {
        return $this->hasOne('App\Models\Album','id','albumId');
    }
    
}
