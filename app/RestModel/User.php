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
                    'image'           => 'default.png',
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

        $record = $record ? $record->toArray() : [];

        $data->setAttribute('notification',$notification);
        $data->setAttribute('record', $record);

        return $data;

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
                      ->select('records.id','records.type','records.heartbeat_count','records.stress_level',
                               'resources.id as resource_id','resources.type as resource_type','resources.set_name as resource_set_name',
                               'resources.filename as resource_filename',
                               'records.created_at','records.updated_at')
                      ->join('resources', 'records.resources_id','=', 'resources.id')
                      ->where(['resources.status' => 1, 'resources.deleted' => 0])
                      ->orderBy('id', 'desc');

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

        return ['status' => true, 'data' => [] ];

    }

    public function disconnect($status)
    {

        if(!$status) return ['status' => false, 'message' => 'No requests / Not Connected'];

        $status->delete();

        return [ 'status' => true, 'data' => [] ];

    }

    public function accept($status)
    {
        if(!$status) return ['status' => false, 'message' => 'No requests / Not Connected'];

        if($status->connection_status != 'Waiting for your confirmation') return ['status' => false, 'message' => 'No Connection Request'];

        $status->update(['status' => 1]);

        return [ 'status' => true, 'data' => [] ];
    }

    public function connections()
    {
        return $this->hasMany('App\RestModel\Connection')
                    ->selectRaw('users.id, users.name, users.email, users.image, users.profile_post, users.gender, users.age, users.birthday, users.phonenumber,
                                 CONCAT(resources.type,"/",resources.set_name,"/",resources.filename) as resource_file, records.heartbeat_count, users.is_online')
                    ->orWhere('friend_id', request()->user()->id)
                    ->leftJoin('users', 'users.id', '=', DB::raw('CASE '.request()->user()->id.' WHEN connections.user_id THEN connections.friend_id ELSE connections.user_id END'))
                    ->leftJoin('records', 'records.user_id', '=', 'users.id')
                    ->leftJoin('resources', 'records.resources_id','=', 'resources.id')
                    ->where('connections.status', 1)
                    ->orderBy('records.id', 'DESC')
                    ->groupBy('users.id');
    }

    public function posts($count)
    {

        return $this->hasMany('App\RestModel\Post')
                    ->selectraw('id, content, created_at')
                    ->simplePaginate($count);

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

}
