<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','api_token','gender','age','birthday','phonenumber','image','profile_post','paid_emoji_set','basic_emoji_set','status','is_online','deleted','facebook_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function searchFilter($data)
    {
        $query = DB::table('users as u')
                ->selectRaw('MAX(r.id) AS record_id,u.image, u.name, u.gender,
                            u.age, u.country, r.heartbeat_count, u.profile_post,
                            if(u.is_online,"online","offline") as active_level,
                            r.emotion_value, r.stress_level,
                            GROUP_CONCAT(CASE WHEN r.emotion_value = "sad" OR r.emotion_value = "anxious"THEN -3
                                              WHEN r.emotion_value = "happy" OR r.emotion_value = "zen" OR r.emotion_value = "excitement" THEN 3
                                              WHEN r.emotion_value = "pleasant" THEN 1
                                              WHEN r.emotion_value = "unpleasant" OR r.emotion_value = "confused" OR r.emotion_value = "challenged" OR r.emotion_value = "hyped" THEN -1
                                              WHEN r.emotion_value = "calm" THEN 0
                                              ELSE 0 END)as upmood_meter
                            ')
                ->leftJoin('records as r',function($qry){
                    $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
                });

        $res = User::filters($query, $data)->groupBy('name')
                ->paginate(10);

        return $res;
    }

    public static function advCardCounts($data){

        $query = DB::table('users as u')
                ->selectRaw('MAX(r.id) AS record_id,u.image, u.name, u.gender,
                            u.age, u.country, r.heartbeat_count, u.profile_post,
                            if(u.is_online,"online","offline") as active_level,
                            r.emotion_value, r.stress_level, COUNT( CASE WHEN gender = "male" THEN 1 END ) as maleRatio, COUNT( CASE WHEN gender = "female" THEN 1 END ) as femaleRatio,  COUNT(DISTINCT country) as countryCount')
                ->leftJoin('records as r',function($qry){
                    $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
                });

        $res = User::filters($query, $data)->first();

        return $res;
    }

    public static function filters($query, $data){
        if(isset($data['search']) && $data['search'] != '' && $data['search'] != null){
            $query = $query->where(function($qry) use($data){
                $qry->where('name','like','%'.$data['search'].'%')
                    ->orWhere('profile_post','like','%'.$data['search'].'%')
                    ->orWhere('emotion_value','like','%'.$data['search'].'%');
            });
        }
        if(isset($data['filterValue']) && $data['filterValue'] != '' && $data['filterValue'] != null){
            if($data['filter'] == 'age'){
                $query = $query->where(function($qry) use($data){
                    $qry->whereBetween('age',$data['filterValue']);
                });
            }else{
                $query = $query->where(function($qry) use($data){
                    $qry->where('gender','like',$data['filterValue']);
                    $qry->orWhere('is_online','like',$data['filterValue']);
                    $qry->orWhere('country','like',$data['filterValue']);
                    $qry->orWhere('emotion_value','like',$data['filterValue']);
                });
            }
        }

        if(isset($data['sortValue']) && $data['sortValue'] != '' && $data['sortValue'] != null){
            $query = $query->orderBy($data['sortValue'],'ASC');
        }

        return $query;
    }

    public static function getCountryList()
    {
        $res = DB::table('users')
            ->select('country')
            ->whereNotNull('country')
            ->groupBy('country')->get();
        return $res;
    }

    public static function getEmotionList()
    {
        $res = Records::select('emotion_value')
            ->whereNotNull('emotion_value')
            ->groupBy('emotion_value')
            ->get();

        return $res;
    }
}
