<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	protected $table = 'sales';

	// Relación one to many / de uno a muchos
   	public function SalesDetail(){
   		return $this->hasMany('App\SalesDetail');
   	}

   	// Relacion de muchos a uno
   	public function users(){
   		return $this->belongsTo('App\User','user_id');
   	}

   	// Relacion de muchos a uno
   	public function client(){
   		return $this->belongsTo('App\Client','client_id');
   	}
}
