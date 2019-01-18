<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StudViewController extends Controller {
    public function index(){
        $drzave = DB::select('select * from drzave');
        return view('ListCountries',['name'=>$drzave]);
    }
}