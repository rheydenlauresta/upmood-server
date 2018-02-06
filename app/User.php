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
                ->selectRaw('u.id,u.image, u.name, u.gender,
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


    // user profile
    public static function getProfile($id)
    {
        $res = User::select('users.id','users.name','users.age','users.country','r.heartbeat_count','r.stress_level','r.emotion_set', 
            DB::raw('(CASE WHEN r.emotion_value = "sad" OR r.emotion_value = "anxious"THEN "sad"
            WHEN r.emotion_value = "happy" OR r.emotion_value = "zen" OR r.emotion_value = "excitement" THEN "happy"
            WHEN r.emotion_value = "pleasant" THEN "pleasant"
            WHEN r.emotion_value = "unpleasant" OR r.emotion_value = "confused" OR r.emotion_value = "challenged" OR r.emotion_value = "hyped" THEN "unpleasant"
            WHEN r.emotion_value = "loading" OR r.emotion_value = "calm" THEN "calm"
            ELSE 0 END) as upmood_meter'),'r.emotion_value')
            ->leftJoin('records as r',function($qry){
                $qry->on('r.user_id', '=', 'users.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = users.id)'));
            })
            ->where('users.id',$id)
            ->first();

        return $res;
    }

    public static function getRecords($id)
    {
        $res = Records::where('records.user_id',$id)
            ->leftJoin('reactions',function($query){
                $query->on('reactions.record_id','=','records.id')->where('reactions.id','=',DB::raw('(select max(reactions.id) from reactions where reactions.record_id = records.id)'));
            })
            ->leftJoin('resources',function($query){
                $query->on('resources.id','=','reactions.reaction_resource_id');
            })
            ->select('records.created_at','records.heartbeat_count','records.ppi','records.total_ppi','records.stress_level','records.emotion_set','records.emotion_value','resources.set_name','resources.filename','resources.type')
            ->orderBy('records.id','DESC')
            ->get();

        return $res;
    }

    public static function getFeatured($id)
    {
        $res = Feature::where('features.user_id',$id)
            ->leftJoin('users',function($query){
                $query->on('features.friend_id','=','users.id');
            })
            ->leftJoin('records',function($query){
                $query->on('records.user_id','=','features.friend_id')->where('records.id','=',DB::raw('(select max(r.id) from records as r where r.user_id = features.friend_id)'));
            })
            ->leftJoin('reactions',function($query) use($id){
                $query->on('reactions.record_id','=','records.id')->where('reactions.id','=',DB::raw('(select max(reactions.id) from reactions where reactions.record_id = records.id and reactions.user_id = features.user_id)'));
            })
            ->leftJoin('resources',function($query){
                $query->on('resources.id','=','reactions.reaction_resource_id');
            })
            ->select('users.name','records.emotion_set','records.emotion_value','resources.set_name','resources.filename','resources.type')
            ->orderBy('features.order','DESC')
            ->get();

        return $res;
    }

    public static function getCalendar($data)
    {
        $date = explode('/',$data['date']);
        if(strlen($date[0]) == 1){
            $date[0] = '0'.$date[0];
        }
        $date_format = $date[1].'-'.$date[0];

        $records =  Records::select(DB::raw('CONCAT("calendar-ic emoji-gummybear-",records.emotion_value) as customClass'),DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'))
                    ->where('records.user_id', $data['id'])
                    ->where('records.created_at', 'like','%'.$date_format.'%')
                    ->get();
        // $records =  Records::select(DB::raw('CONCAT("calendar-ic emoji-",records.emotion_set,"-",records.emotion_value) as customClass'),DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'))

        return $records;
    }
}
