<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\DeviceToken;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\RestModel\Notification;
use DB;
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

    public function testfcm($module, $user_id, $friend_id, $tokens)
    {
        //
        // $test = DB::table('groups')
        //     ->selectraw('user_groups.user_id as userToNoti,groups.id as group_id,groups.name as group_name,user_groups.friend_id,groups.emotion,groups.stress_level,groups.heartbeat,groups.my_mood,user_groups.user_id as user_id,users.name,users.email,users.image,records.heartbeat_count,records.stress_level,records.emotion_value,records.type')
        //     ->join('user_groups',function($query){
        //         $query->on('user_groups.group_id','=','groups.id');
        //     })
        //     ->join('users',function($query){
        //         $query->on('user_groups.friend_id','=','users.id');
        //         $query->where('users.is_online',1);
        //     })
        //     ->leftJoin('records',function($qry){
        //         $qry->on('records.user_id', '=', 'users.id')->where('records.id','=',DB::raw('(select max(records.id) from records where records.user_id = users.id)'));
        //     })
        //     ->leftJoin('resources', 'records.resources_id','=', 'resources.id')
        //     ->where('notification_type','=','minutes')
        //     ->where('type_data','=',10)
        //     ->get();

        // foreach ($test as $key => $value) {
        //     # code...
        //     $data = [
        //         'id'=>$value->user_id,
        //         'name'=>$value->name,
        //         'email'=>$value->email,
        //         'image'=>$value->image,
        //     ];

        //     if(isset($value->my_mood) && $value->my_mood != 0){
        //         if(isset($value->emotion) && $value->emotion == 1){
        //             $data['emotion_value'] = $value->emotion_value;
        //         }
        //         if(isset($value->heartbeat) && $value->heartbeat == 1 && $value->type == 'automated'){
        //             $data['heartbeat_count'] = $value->heartbeat_count;
        //         }
        //         if(isset($value->stress_level) && $value->stress_level == 1){
        //             $data['stress_level'] = $value->stress_level;
        //         }
        //     }

        //     dd($data);
        // }
        //     dd('no notif');



        $data = $this->fcmResponse($module);

        $notification = new Notification;

        $notification->user_id = $user_id;
        $notification->friend_id = $friend_id;
        $notification->type_id = $data['type_id'];
        $notification->content = json_encode($data);
        $notification->seen = 0;

        $notification->save();

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
