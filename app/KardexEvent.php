<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KardexEvent extends Model
{
    protected $table = 'kardex events';

    // Relación one to many / de uno a muchos
   	public function kardex(){
   		return $this->hasMany('App\kardex');
   	}
}
