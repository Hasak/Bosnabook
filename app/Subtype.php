<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    //
    public function tajp(){
        return $this->belongsTo("App\Type",'typeid');
    }
    protected $table='subtypeacc';
}
