<?php

namespace App\RestModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','api_token','gender','age','birthday','phonenumber','image','profile_post','paid_emoji_set','basic_emoji_set','status','is_online','deleted','facebook_id','record_count','post_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeUpdate_create_user($query)
    {
        
        $data = $query->firstOrCreate(
                ['facebook_id' => request('facebook_id')],
                [
                    'facebook_id'     => request('facebook_id'),
                    'name'            => request('name'),
                    'gender'          => request('gender'),
                    'age'             => request('age'),
                    'birthday'        => request('birthday'),
                    'phonenumber'     => request('phonenumber'),
                    'image'           => request('image'),
                    'profile_post'    => null,
                    'paid_emoji_set'  => null,
                    'basic_emoji_set' => 'regular',
                    'api_token'       => 'UpmoodUserAPI-'.str_random(60).uniqid(),
                    'email'           => request('email'),
                    'record_count'    => 0,
                    'post_count'      => 0,
                    'reaction_count'  => 0,
                    'status'          => 0,
                    'is_online'       => 1,
                    'deleted'         => 0
                ]
        );

        $user = $query->find($data->id);

        $notification = $user->notifications(0, 'all')->count();

        $record = $user->records([
            'limit' => 1
        ]);

        $record = $record ? $record->toArray() : (Object) [];

        $data->setAttribute('notification',$notification);
        $data->setAttribute('record', $record);

        return $data;

    }

    public function scopeStatus($query)
    {
     
        $user = request()->user();

        $user->status = request('status');

        if(!$user->save()){

            return [
                'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

        }

        return [
            'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'data'    => [
                'status' => $user->status
            ]
        ];

    }

    public function scopeBasicEmoji($query)
    {
     
        $user = request()->user();

        $user->basic_emoji_set = request('set_name');

        if(!$user->save()){

            return [
                'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

        }

        return [
            'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'data'    => [
                'basic_emoji_set' => $user->basic_emoji_set
            ]
        ];

    }

    public function notifications($status, $type = null)
    {
        $query = $this->hasMany('App\RestModel\Notification')
                      ->select('id','type_id', 'content', 'created_at');

        if(!$type) return $query->where('seen', $status)->simplePaginate(20);

        if($type == 'all') return $query->where('seen', $status)->get();

        if($this->notiType($type) == 4) return $query->where('type_id', 4)->simplePaginate(20);

        return $query->where('type_id', $this->notiType($type))->where('seen', $status)->simplePaginate(20);

    }

    public function notiType($type)
    {
        if($type == 'connect') return 1;
        if($type == 'approve') return 2;
        if($type == 'status') return 3;
        if($type == 'react') return 4;

        return 0;
    }

    public function records($filter = null)
    {
        $query = $this->hasMany('App\RestModel\Records')
                      ->selectraw('records.id, records.type, records.heartbeat_count, records.stress_level, records.ppi, CONCAT(records.emotion_set,"/emoji/",records.emotion_value,".png") as filepath,
                               records.emotion_value, records.emotion_set, records.emotion_level, records.longitude, records.latitude,
                               records.created_at')
                      ->orderBy('id', 'DESC');

        if(!$filter) return $query->get();

        if(isset($filter['limit'])){

            if($filter['limit'] == 1) return $query->first();

            if($filter['limit'] > 1) return $query->simplePaginate($filter['limit']);

        }

    }

    public function scopeSearch($query)
    {
        return $query->selectRaw('  
                  users.id, users.name, users.email, users.image, users.profile_post,
                  CASE ( SELECT CASE CONCAT(connections.status)
                                  WHEN 1 THEN "Friend"
                                  WHEN 0 THEN CASE users.id WHEN connections.user_id THEN "For Confirmation" WHEN connections.friend_id THEN "Pending" END
                                  ELSE "Connect"
                             END as connection_status
                      FROM connections WHERE ( connections.friend_id = users.id AND connections.user_id = '.request()->user()->id.') OR ( connections.user_id = users.id AND connections.friend_id = '.request()->user()->id.') )
                      WHEN "Friend" THEN "Friend"
                      WHEN "Pending" THEN "Pending"
                      WHEN "For Confirmation" THEN "For Confirmation"
                      ELSE "Connect"
                  END as connection_status
              ')
              ->where('users.id', '!=', request()->user()->id)
              ->where('users.name', 'like', '%'.request('keyword').'%')
              ->orWhere('users.email', 'like', '%'.request('keyword').'%')
              ->paginate(20);

    }

    public function scopeCheckUser($query, $module)
    {
        $user = $query->find(request('id'));

        if(!$user) return ['status' => false, 'message' => 'No User Found'];

        $connection = $user->checkConnections($module);

        return $this->$module($connection);

    }

    public function checkConnections($module)
    {
        return $this->hasMany('App\RestModel\Connection')
                    ->selectRaw('CASE connections.status
                                      WHEN 1 THEN "Already Connected"
                                      WHEN 0 THEN CASE '.request('id').' WHEN connections.user_id THEN "Waiting for your confirmation" WHEN connections.friend_id THEN "Already send Invitation" END
                                 END as connection_status, connections.id')
                    ->where('friend_id', request()->user()->id)
                    ->orWhere('user_id', request()->user()->id)
                    ->where('friend_id', request('id'))
                    ->first();
    }

    public function connect($status)
    {
        if($status) return ['status' => false, 'message' => $status->connection_status];

        Connection::create([
            'user_id'   => request()->user()->id,
            'friend_id' => (int) request('id'),
        ]);

        // fcm notification
        $user = User::find(request('id'));
        
        $data = [
            "module"=>"Push Notification",
            "type"=>"Connect Request",
            "type_id"=>"1",
            "request_from"=> [
                                "id"=>request()->user()->id,
                                "name"=>request()->user()->name,
                                "image"=>request()->user()->image,
                            ],
            "request_to"=>  [
                                "id"=>$user->id,
                                "name"=>$user->name,
                            ],
        ];

        DeviceToken::fcmSend($data, [$user->id]);
        // /fcm notification

        return ['status' => true, 'data' => (Object) [] ];

    }

    public function disconnect($status)
    {
        if(!$status) return ['status' => false, 'message' => 'No requests / Not Connected'];

        $status->delete();
        UserGroup::remove();

        return [ 'status' => true, 'data' => (Object) [] ];

    }

    public function accept($status)
    {
        if(!$status) return ['status' => false, 'message' => 'No requests / Not Connected'];

        if($status->connection_status != 'Waiting for your confirmation') return ['status' => false, 'message' => 'No Connection Request'];

        $status->update(['status' => 1]);

        // fcm notification
        $user = Connection::where('connections.id',$status->id)
                            ->join('users','users.id','=',DB::raw('CASE '.request()->user()->id.' WHEN connections.friend_id THEN connections.user_id ELSE connections.friend_id END'))
                            ->first();

        $data = [
            "module"=>"Push Notification",
            "type"=>"Approved Request",
            "type_id"=>"2",
            "request_from"=> [
                "id"=>$user->id,
                "name"=>$user->name,
                "image"=>$user->image,
            ],
            "request_to"=> [
                "id"=>request()->user()->id,
                "name"=>request()->user()->name,
                "image"=>request()->user()->image,
            ],
        ];

        DeviceToken::fcmSend($data, [$user->id]);

        // /fcm notification

        return [ 'status' => true, 'data' => (Object) [] ];
    }

    public function connections()
    {

        return Connection::where(function($qry){
                        $qry->where('connections.user_id',request()->user()->id);
                        $qry->orWhere('connections.friend_id', request()->user()->id);
                    })
                    ->where('connections.status', 1)
                    ->leftJoin('users',function($qry){
                        $qry->on('users.id', '=', DB::raw('CASE '.request()->user()->id.' WHEN connections.user_id THEN connections.friend_id ELSE connections.user_id END'));
                    })
                    ->leftJoin('records',function($qry){
                        $qry->on('records.user_id', '=', 'users.id')->where('records.id','=',DB::raw('(select max(records.id) from records where records.user_id = users.id)'));
                    })
                    ->leftJoin('resources', 'records.resources_id','=', 'resources.id')
                    ->selectRaw('users.id, users.name, users.email, users.image, users.profile_post, users.gender, users.age, users.birthday, users.phonenumber,
                                 CONCAT(resources.type,"/",resources.set_name,"/",resources.filename) as resource_file, records.heartbeat_count,users.is_online')
                    ->orderBy('records.id','DESC')
                    ->groupBy('records.user_id');
    }

    public function posts($count)
    {

        return $this->hasMany('App\RestModel\Post')
                    ->selectraw('id, content, created_at')
                    ->simplePaginate($count);

    }

    public function groups($id = null)
    {

        $query = $this->hasMany('App\RestModel\Group')
                    ->selectraw('groups.*, users.id as friend_id, users.name as user_name, users.image as user_image, users.email as user_email,user_groups.friend_id as user_group_friend_id')
                    ->leftJoin('user_groups', function($join){
                        $join->on('user_groups.group_id', '=', 'groups.id');
                        $join->where('user_groups.user_id', '=', request()->user()->id);
                    })
                    ->leftJoin('users', function($join){
                        $join->on('user_groups.friend_id', '=', 'users.id');
                    });

        if($id){
          $query = $query->where('groups.id', $id);
        }

        return $query->get()->groupBy('id')->transform(function ($value, $key){

            if($value[0]['user_group_friend_id'] != null){

                $friend_list = collect($value)->transform(function ($value, $key){
                                    return [
                                        'id'    => $value->friend_id,
                                        'name'  => $value->user_name,
                                        'image' => $value->user_image,
                                        'email' => $value->user_email,
                                    ];
                                });
            }else{
                $friend_list = [];
            }

            $data = [
                'id'                => $value[0]['id'],
                'name'              => $value[0]['name'],
                'emotion'           => $value[0]['emotion'],
                'heartbeat'         => $value[0]['heartbeat'],
                'stress_level'      => $value[0]['stress_level'],
                'my_mood'           => $value[0]['my_mood'],
                'notification_type' => $value[0]['notification_type'],
                'type_data'         => $value[0]['type_data'],
                'emotions'          => $value[0]['emotions'],
                'members'           => $friend_list,
            ];

            return $data;

        })->values();

    }


    public function connectionList($id = null)
    {
        $query = DB::table('connections')
                ->selectraw('connections.*, users.id as user_friend_id, users.name as user_name, users.image as user_image, users.email as user_email')

                ->where(function($qry){
                    $qry->where('connections.user_id',request()->user()->id);
                    $qry->orWhere('connections.friend_id',request()->user()->id);
                })
                ->leftJoin('user_groups',function($join){
                    $join->on('user_groups.friend_id','=',DB::raw('CASE '.request()->user()->id.' WHEN connections.user_id THEN connections.friend_id ELSE connections.user_id END'));
                    $join->where('user_groups.user_id','=',request()->user()->id);
                })
                ->where('user_groups.user_id','=',null)
                ->where('connections.status','=',1)
                ->leftJoin('users', 'users.id', '=', DB::raw('CASE '.request()->user()->id.' WHEN connections.user_id THEN connections.friend_id ELSE connections.user_id END'));           

        return $query->get()->groupBy('id')->transform(function ($value, $key){

            $data = [

                    'id'    => $value[0]->user_friend_id,
                    'name'  => $value[0]->user_name,
                    'image' => $value[0]->user_image,
                    'email' => $value[0]->user_email,

            ];

            return $data;

        })->values();
    
    }

    public function featuredList($id = null)
    {
        $query = DB::table('connections')
                ->selectraw('connections.*, users.id as user_friend_id, users.name as user_name, users.image as user_image, users.email as user_email')

                ->where(function($qry){
                    $qry->where('connections.user_id',request()->user()->id);
                    $qry->orWhere('connections.friend_id',request()->user()->id);
                })
                ->leftJoin('features',function($join){
                    $join->on('features.friend_id','=',DB::raw('CASE '.request()->user()->id.' WHEN connections.user_id THEN connections.friend_id ELSE connections.user_id END'));
                    $join->where('features.user_id','=',request()->user()->id);
                })
                ->where('features.user_id','=',null)
                ->where('connections.status','=',1)
                ->leftJoin('users', 'users.id', '=', DB::raw('CASE '.request()->user()->id.' WHEN connections.user_id THEN connections.friend_id ELSE connections.user_id END'));           

        return $query->get()->groupBy('id')->transform(function ($value, $key){

            $data = [

                    'id'    => $value[0]->user_friend_id,
                    'name'  => $value[0]->user_name,
                    'image' => $value[0]->user_image,
                    'email' => $value[0]->user_email,

            ];

            return $data;

        })->values();
    
    }

    public function reactions($owner, $count)
    {
      
        $query = $this->hasMany('App\RestModel\Reaction', 'friend_id')
                    ->selectraw('reactions.id,
                                 users.name, users.image, 
                                 CONCAT(emoji.type,"/",emoji.set_name,"/",emoji.filename) as emoji_path,
                                 CONCAT(reaction.type,"/",reaction.set_name,"/",reaction.filename) as reaction_path,
                                 posts.content as own_post,
                                 reactions.created_at')
                    ->leftJoin('users', 'reactions.user_id', '=', 'users.id')
                    ->leftJoin('resources as emoji', 'reactions.emoji_resource_id', '=', 'emoji.id')
                    ->leftJoin('resources as reaction', 'reactions.reaction_resource_id', '=', 'reaction.id')
                    ->leftJoin('posts', 'reactions.post_id', '=', 'posts.id')
                    ->simplePaginate($count);

        $query->appends(request()->query());

        return $query;

    }

    // view and validate other users
    public function scopeViewOthers($query, $id)
    {
        $groups = Group::where('user_id',$id);

        $user_group = UserGroup::where('user_groups.friend_id',request()->user()->id)
            ->where('user_groups.user_id',$id)
            ->join('groups','groups.id','=','user_groups.group_id')
            ->first();

        $record = Records::where('user_id',$id)->orderBy('id','desc')->first();

        $user = User::find($id);

        $data = [
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'image'=>$user->image,
        ];

        if(isset($user_group->my_mood) && $user_group->my_mood != 0){
            if(isset($user_group->emotion) && $user_group->emotion == 1){
                $data['emotion_value'] = $record->emotion_value;
            }
            if(isset($user_group->heartbeat) && $user_group->heartbeat == 1 && $record->type == 'automated'){
                $data['heartbeat_count'] = $record->heartbeat_count;
            }
            if(isset($user_group->stress_level) && $user_group->stress_level == 1){
                $data['stress_level'] = $record->stress_level;
            }
        }

        return $data;
    }

}
