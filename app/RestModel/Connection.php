<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
	protected $fillable = [
        'user_id', 'friend_id', 'status'
    ];

    protected $table = 'connections';
}
