<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    public function packageInfo()
    {
        return $this->hasOne('App\Models\Package','id','packageId');
    }

    public function listernerInfo()
    {
        return $this->hasOne('App\Models\Listerner','id','listernerId');
    }
    
}
