<?php

namespace App\RestModel;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
                    'status'          => 1,
                    'is_online'       => 1,
                    'deleted'         => 0
                ]
        );

        $user = $query->find($data->id);

        $notification = $user->notifications(0)->count();

        $record = $user->records([
            'limit' => 1
        ]);

        $record = $record ? $record->toArray() : [];

        $data->setAttribute('notification',$notification);
        $data->setAttribute('record', $record);

        return $data;

    }

    public function notifications($status)
    {
        return $this->hasMany('App\RestModel\Notification')->where('seen', $status)->get();
    }

    public function records($filter = null)
    {
        $query = $this->hasMany('App\RestModel\Records')
                      ->select('records.id','records.type','records.heartbeat_count',
                               'resources.id as resource_id','resources.type as resource_type','resources.set_name as resource_set_name',
                               'resources.filename as resource_filename',
                               'records.created_at','records.updated_at')
                      ->join('resources', 'records.resources_id','=', 'resources.id')
                      ->where(['resources.status' => 1, 'resources.deleted' => 0])
                      ->orderBy('id', 'desc');

        if(!$filter) return $query;

        if(isset($filter['limit']))

            if($filter['limit'] == 1) return $query->first();

            if($filter['limit'] > 1) return $query->take($filter['limit'])->get();


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


}
