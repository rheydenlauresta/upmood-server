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

    public function testfcm()
    {
        $data = [
                    "module"=>"Push Notification",
                    "type"=>"Approved Request",
                    "type_id"=>"1",
                    "request_from"=> [
                                        "user_id"=>request()->user()->id,
                                        "user_name"=>request()->user()->name,
                                        "user_image"=>request()->user()->image,
                                    ],
                    "request_to"=>  [
                                        "user_id"=>"1",
                                        "user_name"=>"test",
                                    ],
                ];

        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(1);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option_builder = $optionBuiler->build();
        $data_builder = $dataBuilder->build();

        $tokens = DeviceToken::where('user_id',request()->user()->id)->pluck('token')->toArray();

        $response = FCM::sendTo($tokens, $option_builder, $notification = null, $data_builder);

        // return $response->numberSuccess();
        // return $response->numberFailure();
    }

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
}
