<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class FcmLog extends Model
{
	protected $fillable = [
        'user_id', 'friend_id', 'numberSuccess', 'numberFailure', 'numberModification', 'tokensToDelete', 'tokensToModify', 'tokensToRetry', 'tokensWithError'
    ];

    protected $table = 'fcm_logs';
    //
}
