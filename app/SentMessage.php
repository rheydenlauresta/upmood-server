<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentMessage extends Model
{
    //
    protected $table = 'sent_messages';
    
    protected $fillable = [
        'email',
        'subject',
        'message',
    ];
}
