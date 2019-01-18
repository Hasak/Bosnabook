<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    //
    public function tajp(){
        return $this->belongsTo("App\Autatypes",'type');
    }
    public function kimin(){
        return $this->belongsTo("App\User",'owner');
    }
    public function gorivoo(){
        return $this->belongsTo("App\Fuel",'gorivo');
    }
    protected $table='auta';
    protected $guarded=['id'];
}
