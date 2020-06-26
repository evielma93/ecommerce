<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';


   	// Relacion de muchos a uno
   	public function products(){
   		return $this->belongsTo('App\Product','product_id');
   	}

   	// Relación one to many / de uno a muchos
   	public function kardex(){
   		return $this->hasMany('App\kardex');
   	}


}
