<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   	protected $table = 'categories';

   	// Relación one to many / de uno a muchos
   	public function products(){
   		return $this->hasMany('App\Product');
   	}

   	// Relacion de muchos a uno
   	public function users(){
   		return $this->belongsTo('App\User','user_id');
   	}

}
