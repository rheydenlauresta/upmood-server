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
                ->selectRaw('u.image, u.name, u.gender,
                            u.age, u.country, r.heartbeat_count, u.profile_post,
                            if(u.is_online,"online","offline") as active_level,
                            r.emotion_value, r.stress_level,
                            SUM(CASE WHEN up_meter.emotion_value = "sad" OR up_meter.emotion_value = "anxious"THEN -3
                            WHEN up_meter.emotion_value = "happy" OR up_meter.emotion_value = "zen" OR up_meter.emotion_value = "excitement" THEN 3
                            WHEN up_meter.emotion_value = "pleasant" OR up_meter.emotion_value = "calm" THEN 1
                            WHEN up_meter.emotion_value = "unpleasant" OR up_meter.emotion_value = "confused" OR up_meter.emotion_value = "challenged" OR up_meter.emotion_value = "hyped" THEN -1
                            WHEN up_meter.emotion_value = "loading" THEN 0
                            ELSE 0 END) / SUM(CASE WHEN up_meter.emotion_value = "sad" OR up_meter.emotion_value = "anxious"THEN 3
                            WHEN up_meter.emotion_value = "happy" OR up_meter.emotion_value = "zen" OR up_meter.emotion_value = "excitement" THEN 3
                            WHEN up_meter.emotion_value = "pleasant" OR up_meter.emotion_value = "calm" THEN 1
                            WHEN up_meter.emotion_value = "unpleasant" OR up_meter.emotion_value = "confused" OR up_meter.emotion_value = "challenged" OR up_meter.emotion_value = "hyped" THEN 1
                            WHEN up_meter.emotion_value = "loading" THEN 0
                            ELSE 0 END) * 100 as upmood_meter 
                            ')
                ->leftJoin('records as r',function($qry){
                    $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
                })
                ->leftJoin('records as up_meter',function($qry){
                    $qry->on('up_meter.user_id', '=', 'u.id');
                });

        $res = User::filters($query, $data)->groupBy('name')
                ->paginate(10);

        return $res;
    }

    public static function advCardCounts($data){

        $query = DB::table('users as u')
                ->selectRaw('u.image, u.name, u.gender,
                            u.age, u.country, r.heartbeat_count, u.profile_post,
                            if(u.is_online,"online","offline") as active_level,
                            r.emotion_value, r.stress_level, COUNT( CASE WHEN gender = "male" THEN 1 END ) as maleRatio, COUNT( CASE WHEN gender = "female" THEN 1 END ) as femaleRatio,  COUNT(DISTINCT country) as countryCount,
                            SUM(CASE WHEN up_meter.emotion_value = "sad" OR up_meter.emotion_value = "anxious"THEN -3
                            WHEN up_meter.emotion_value = "happy" OR up_meter.emotion_value = "zen" OR up_meter.emotion_value = "excitement" THEN 3
                            WHEN up_meter.emotion_value = "pleasant" OR up_meter.emotion_value = "calm" THEN 1
                            WHEN up_meter.emotion_value = "unpleasant" OR up_meter.emotion_value = "confused" OR up_meter.emotion_value = "challenged" OR up_meter.emotion_value = "hyped" THEN -1
                            WHEN up_meter.emotion_value = "loading" THEN 0
                            ELSE 0 END) / SUM(CASE WHEN up_meter.emotion_value = "sad" OR up_meter.emotion_value = "anxious"THEN 3
                            WHEN up_meter.emotion_value = "happy" OR up_meter.emotion_value = "zen" OR up_meter.emotion_value = "excitement" THEN 3
                            WHEN up_meter.emotion_value = "pleasant" OR up_meter.emotion_value = "calm" THEN 1
                            WHEN up_meter.emotion_value = "unpleasant" OR up_meter.emotion_value = "confused" OR up_meter.emotion_value = "challenged" OR up_meter.emotion_value = "hyped" THEN 1
                            WHEN up_meter.emotion_value = "loading" THEN 0
                            ELSE 0 END) * 100 as upmood_meter')
                ->leftJoin('records as r',function($qry){
                    $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
                })
                ->leftJoin('records as up_meter',function($qry){
                    $qry->on('up_meter.user_id', '=', 'u.id');
                });

        $res = User::filters($query, $data)->first();

        return $res;
    }

    public static function filters($query, $data){
        if(isset($data['search']) && $data['search'] != ''){
            $query = $query->where(function($qry) use($data){
                $qry->where('name','like','%'.$data['search'].'%')
                    ->orWhere('profile_post','like','%'.$data['search'].'%')
                    ->orWhere('r.emotion_value','like','%'.$data['search'].'%');
            });
        }
        if(isset($data['filterValue']) && $data['filterValue'] != ''){
            if($data['filter'] == 'age'){
                $query = $query->where(function($qry) use($data){
                    $qry->whereBetween('age',$data['filterValue']);
                });
            }else{
                $query = $query->where(function($qry) use($data){
                    $qry->where('gender','like',$data['filterValue']);
                    $qry->orWhere('is_online','like',$data['filterValue']);
                    $qry->orWhere('country','like',$data['filterValue']);
                    $qry->orWhere('r.emotion_value','like',$data['filterValue']);
                });
            }
        }

        if(isset($data['filterValue2']) && $data['filterValue2'] != ''){
            if($data['filter2'] == 'age'){
                $query = $query->where(function($qry) use($data){
                    $qry->whereBetween('age',$data['filterValue2']);
                });
            }else{
                $query = $query->where(function($qry) use($data){
                    $qry->where('gender','like',$data['filterValue2']);
                    $qry->orWhere('is_online','like',$data['filterValue2']);
                    $qry->orWhere('country','like',$data['filterValue2']);
                    $qry->orWhere('r.emotion_value','like',$data['filterValue2']);
                });
            }
        }

        if(isset($data['filterValue3']) && $data['filterValue3'] != ''){
            if($data['filter3'] == 'age'){
                $query = $query->where(function($qry) use($data){
                    $qry->whereBetween('age',$data['filterValue3']);
                });
            }else{
                $query = $query->where(function($qry) use($data){
                    $qry->where('gender','like',$data['filterValue3']);
                    $qry->orWhere('is_online','like',$data['filterValue3']);
                    $qry->orWhere('country','like',$data['filterValue3']);
                    $qry->orWhere('r.emotion_value','like',$data['filterValue3']);
                });
            }
        }

        if(isset($data['filterValue4']) && $data['filterValue4'] != ''){
            if($data['filter4'] == 'age'){
                $query = $query->where(function($qry) use($data){
                    $qry->whereBetween('age',$data['filterValue4']);
                });
            }else{
                $query = $query->where(function($qry) use($data){
                    $qry->where('gender','like',$data['filterValue4']);
                    $qry->orWhere('is_online','like',$data['filterValue4']);
                    $qry->orWhere('country','like',$data['filterValue4']);
                    $qry->orWhere('r.emotion_value','like',$data['filterValue4']);
                });
            }
        }

        if(isset($data['filterValue5']) && $data['filterValue5'] != ''){
            if($data['filter5'] == 'age'){
                $query = $query->where(function($qry) use($data){
                    $qry->whereBetween('age',$data['filterValue5']);
                });
            }else{
                $query = $query->where(function($qry) use($data){
                    $qry->where('gender','like',$data['filterValue5']);
                    $qry->orWhere('is_online','like',$data['filterValue5']);
                    $qry->orWhere('country','like',$data['filterValue5']);
                    $qry->orWhere('r.emotion_value','like',$data['filterValue5']);
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
