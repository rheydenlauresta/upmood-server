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
                            ELSE null END) as upmood_meter 
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

        // $query = DB::table('users as u')
        //         ->selectRaw('u.image, u.name, u.gender,
        //                     u.age, u.country, r.heartbeat_count, u.profile_post,
        //                     if(u.is_online,"online","offline") as active_level,
        //                     r.emotion_value, r.stress_level, COUNT( CASE WHEN gender = "male" THEN 1 END ) as maleRatio, COUNT( CASE WHEN gender = "female" THEN 1 END ) as femaleRatio,  COUNT(DISTINCT country) as countryCount,
        //                     SUM(CASE WHEN up_meter.emotion_value = "sad" OR up_meter.emotion_value = "anxious"THEN -3
        //                     WHEN up_meter.emotion_value = "happy" OR up_meter.emotion_value = "zen" OR up_meter.emotion_value = "excitement" THEN 3
        //                     WHEN up_meter.emotion_value = "pleasant" OR up_meter.emotion_value = "calm" THEN 1
        //                     WHEN up_meter.emotion_value = "unpleasant" OR up_meter.emotion_value = "confused" OR up_meter.emotion_value = "challenged" OR up_meter.emotion_value = "hyped" THEN -1
        //                     WHEN up_meter.emotion_value = "loading" THEN 0
        //                     ELSE 0 END) as upmood_meter')
        //         ->leftJoin('records as r',function($qry){
        //             $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
        //         })
        //         ->leftJoin('records as up_meter',function($qry){
        //             $qry->on('up_meter.user_id', '=', 'u.id');
        //         });

        // $res = User::filters($query, $data)->first();

        // return $res;

        $query = DB::table('users as u')
                ->selectRaw('u.image, u.name, u.gender,
                            u.age, u.country, r.heartbeat_count, u.profile_post,
                            if(u.is_online,"online","offline") as active_level,
                            r.emotion_value, r.stress_level, COUNT( CASE WHEN gender = "male" THEN 1 END ) as maleRatio, COUNT( CASE WHEN gender = "female" THEN 1 END ) as femaleRatio,  COUNT(DISTINCT country) as countryCount,
                            SUM(CASE WHEN r.emotion_value = "sad" OR r.emotion_value = "anxious"THEN -3
                            WHEN r.emotion_value = "happy" OR r.emotion_value = "zen" OR r.emotion_value = "excitement" THEN 3
                            WHEN r.emotion_value = "pleasant" OR r.emotion_value = "calm" THEN 1
                            WHEN r.emotion_value = "unpleasant" OR r.emotion_value = "confused" OR r.emotion_value = "challenged" OR r.emotion_value = "hyped" THEN -1
                            WHEN r.emotion_value = "loading" THEN 0
                            ELSE 0 END) as upmood_meter')
                ->leftJoin('records as r',function($qry){
                    $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
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
                    $qry->whereBetween('age',json_decode($data['ageValue']));
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

        if(isset($data['advanceFilterValues']) && $data['advanceFilterValues'] != ''){
            $json = json_decode($data['advanceFilterValues'] );
            foreach ($json as $key => $value) {

                if($value->selectedFilter == 'age'){
                    $query = $query->where(function($qry) use($value){
                        $qry->whereBetween('age',$value->filterValues);
                    });
                }else{
                    if(isset($value->filterValues) && $value->filterValues != ''){
                        $query = $query->where(function($qry) use($value){
                            $qry->where('gender','like',$value->filterValues);
                            $qry->orWhere('is_online','like',$value->filterValues);
                            $qry->orWhere('country','like',$value->filterValues);
                            $qry->orWhere('r.emotion_value','like',$value->filterValues);
                        });
                    }
                }
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
