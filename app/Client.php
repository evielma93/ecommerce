<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    // Relacion de muchos a uno
   	public function sectors(){
   		return $this->belongsTo('App\Sector','sector_id');
   	}
}
