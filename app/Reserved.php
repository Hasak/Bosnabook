<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserved extends Model
{
    //
    public function accc(){
        return $this->belongsTo("App\Akomodejsns",'accid');
    }
    protected $table="reserved";
}
