<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\DeviceToken;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

use FCM;

class DeviceTokenController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator(request()->all(), [
            'device_id'       => 'required',
            'token'           => 'required',

        ], 'store-device-tokens');

        if($validator['status'] == 422) return json_encode($validator);

        $group = DeviceToken::store();

        return response()->json(array_merge($validator, $group));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function testfcm($tokens)
    {
        //
        $data = [
            "module" => "Push Notification",
            "type" => "Connect Request",
            "type_id" => "1",
            "request_from" => [
                "id" => 166,
                "name" => "Prof. Timothy Hudson",
                "image" => "default.png",
            ],
            "request_to" => [
                "id" => 91,
                "name" => "Prof. Junior Shanahan",
            ],
        ];

        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(1);

        $notificationBuilder = new PayloadNotificationBuilder('test API');
        $notificationBuilder->setBody('tester')
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option_builder = $optionBuiler->build();
        $notification_builder = $notificationBuilder->build();
        $data_builder = $dataBuilder->build();

        // $tokens = DeviceToken::whereIn('user_id',$user_id)->pluck('token')->toArray();

        $res = FCM::sendTo($tokens, $option_builder, $notification_builder, $data_builder);

        return 'Success!!!';
    }

    public function fcmResponse($fcm_type){

        if($fcm_type == 'connect'){

            $data = [
                "module" => "Push Notification",
                "type" => "Connect Request",
                "type_id" => "1",
                "request_from" => [
                    "id" => 166,
                    "name" => "Prof. Timothy Hudson",
                    "image" => "default.png",
                ],
                "request_to" => [
                    "id" => 91,
                    "name" => "Prof. Junior Shanahan",
                ],
            ];

            return $data;

        }elseif($fcm_type == 'accept'){

            $data = [
                "module" => "Push Notification",
                "type" => "Approved Request",
                "type_id" => "2",
                "request_from" => [
                    "id" => 91,
                    "name" => "Prof. Junior Shanahan",
                    "image" => "default.png",
                ],
                "request_to" => [
                    "id" => 166,
                    "name" => "Prof. Timothy Hudson",
                ],
            ];

            return $data;

        }elseif($fcm_type == 'sendReaction'){
            $data = [
                "module"=>"Push Notification",
                "type"=>"Reaction Send",
                "type_id"=>"4",
                'heartbeat'    => '90',
                'post'         => 'Cat again, sitting on a three-legged stool in the pool, and the roof was thatched with fur. It was.',
                'emoji'        => [
                    'emoji_id'    => 1,
                    'emoji_path' => '/emoji/alien/anxious.png',
                ],
                'reaction'     => [
                    'reaction_id'   => '1',
                    'reaction_path' => '/emoji/alien/anxious.png',
                ],
                "request_from" => [
                    "id" => 166,
                    "name" => "Prof. Timothy Hudson",
                    "image" => "default.png",
                ],
                "request_to" => [
                    "id" => 91,
                    "name" => "Prof. Junior Shanahan",
                ],
            ];

            return $data;
        }
    }
}
