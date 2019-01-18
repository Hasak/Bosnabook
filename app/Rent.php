<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    //
	public function accc(){
		return $this->belongsTo("App\Auto",'carid');
	}
    protected $table='rented';
}
