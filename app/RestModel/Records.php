<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
	
    protected $table = 'records';

    public function resources()
    {
    	return $this->hasOne('App\RestModel\Resource');
    }

}
