<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

use FCM;

class DeviceToken extends Model
{
    protected $fillable = [
        'user_id', 'device_id', 'token'
    ];

    protected $table = 'device_tokens';

    public function scopeStore($query)
    {

    	$device = new $this;

		$device->user_id           = request()->user()->id;
		$device->device_id         = request('device_id');
		$device->token             = request('token');


		if(!$device->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'	  => $device->toArray()
        ];

    }

    public function scopeFcmSend($query, $data, $user_id)
    {
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(1);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option_builder = $optionBuiler->build();
        $data_builder = $dataBuilder->build();

        $tokens = DeviceToken::where('user_id',$user_id)->pluck('token')->toArray();
        // dd($tokens);

        $res = FCM::sendTo($tokens, $option_builder, $notification = null, $data_builder);
    }
}
