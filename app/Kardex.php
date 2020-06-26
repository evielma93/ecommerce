<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table = 'kardex';

    // Relación one to many / de uno a muchos
   	public function inventory(){
   		return $this->belongsTo('App\Inventory','inventory_id');
   	}

   	// Relación one to many / de uno a muchos
   	public function kardexDetails(){
   		return $this->hasMany('App\KardexDetails');
   	}

   	// Relación one to many / de uno a muchos
   	public function kardexEvent(){
   		return $this->belongsTo('App\KardexEvent','events_id');
   	}

}
