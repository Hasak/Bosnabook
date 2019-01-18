<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destt extends Model
{
    //
    public function plejs(){
        return $this->belongsTo("App\Subplace",'place');
    }
    protected $table='destinacije';
}
