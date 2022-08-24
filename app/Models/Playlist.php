<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public function listernerInfo()
    {
        return $this->hasOne('App\Models\Listerner','id','listernerId');
    }
}
