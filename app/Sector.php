<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sectors';

    public function clients(){
   		return $this->hasMany('App\Client');
   	}


}
