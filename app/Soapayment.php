<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soapayment extends Model
{
    //
    public function payment_info()
    {
        return $this->hasMany(Payment::class,'soa_number','id');
    }

}
