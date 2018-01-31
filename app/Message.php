<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'contact_message';

    protected $fillable = [
        'user_id', 'email', 'type','content'
    ];
}
