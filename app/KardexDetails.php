<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KardexDetails extends Model
{
    protected $table = 'kardex_details';

    // Relacion de muchos a uno
   	public function kardex(){
   		return $this->belongsTo('App\Kardex','kardex_id');
   	}
}
