<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subplace extends Model
{
    //
    public function plejsp(){
        return $this->belongsTo("App\Place",'placeid');
    }
}
