<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dashboard extends Model
{
    //
    public static function userActivityCount()
    {
      $res = DB::table('users')
                    ->selectRaw('COUNT(CASE WHEN is_online = 1 THEN 1 END)AS online,
                                 COUNT(CASE WHEN is_online = 0 THEN 1 END)AS offline,
                                 COUNT(*) as registered_users')->first();
      return $res;
    }

    public static function countryCount()
    {
        $res = DB::table('users')
                  ->selectRaw('country, COUNT(CASE WHEN is_online = 1 THEN 1 END)AS online, COUNT(CASE WHEN is_online = 0 THEN 1 END) AS offline ')
                    ->groupBy('country')
                    ->orderBy('country','asc')
                    ->get();

        return $res;
    }

    public static function searchFilter($data)
    {
        $res = DB::table('users as u')
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
                if(isset($data['search']) && $data['search'] != '' && $data['search'] != null){
                  $res = $res->where(function($qry) use($data){
                    $qry->where('name','like','%'.$data['search'].'%')
                        ->orWhere('profile_post','like','%'.$data['search'].'%')
                        ->orWhere('emotion_value','like','%'.$data['search'].'%');
                  });
                }
                if(isset($data['filterValue']) && $data['filterValue'] != '' && $data['filterValue'] != null){
                  if($data['filter'] == 'age'){
                    $res = $res->where(function($qry) use($data){
                      $qry->whereBetween('age',$data['filterValue']);
                    });
                  }else{

                    $res = $res->where(function($qry) use($data){
                      $qry->where('gender','like',$data['filterValue']);
                      $qry->orWhere('is_online','like',$data['filterValue']);
                      $qry->orWhere('country','like',$data['filterValue']);
                    });
                  }
                }
                $res = $res->groupBy('name')
                ->paginate(10);

        return $res;
    }

    public static function getUserCountry()
    {
      $res = DB::table('users')
                      ->select('country')
                      ->whereNotNull('country')
                      ->groupBy('country')->get();
      return $res;
    }

    public static function getUserInfo($id)
    {
      $res = DB::table('users')
                ->find($id);
      return $res;
    }

    public static function getUserMood($id)
    {
      $res = DB::table('records')->where('user_id',$id)->get();

      return $res;
    }

    public static function getContactForm()
    {
      $res = DB::table('contact_message')->get();
      return $res;
    }
}
