<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    protected $table = 'medidas';

    // Relación one to many / de uno a muchos
   	public function products(){
   		return $this->hasMany('App\Product');
   	}
}
