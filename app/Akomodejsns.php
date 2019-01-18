<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Akomodejsns extends Model
{
    //
    public function useriuseri(){
        return $this->belongsTo("App\User",'owner');
    }
    public function plejs(){
        return $this->belongsTo("App\Subplace",'place');
    }
    public function sabtajp(){
        return $this->belongsTo("App\Subtype",'subtype');
    }
    protected $table='accs';
    protected $guarded=['id'];
}
