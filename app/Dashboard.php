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
        $res = DB::table('users as u')
                ->selectRaw('country, COUNT(CASE WHEN is_online = 1 THEN 1 END)AS online, COUNT(CASE WHEN is_online = 0 THEN 1 END) AS offline,
                            SUM(CASE WHEN r.emotion_value = "sad" OR r.emotion_value = "anxious"THEN -3
                            WHEN r.emotion_value = "happy" OR r.emotion_value = "zen" OR r.emotion_value = "excitement" THEN 3
                            WHEN r.emotion_value = "pleasant" OR r.emotion_value = "calm" THEN 1
                            WHEN r.emotion_value = "unpleasant" OR r.emotion_value = "confused" OR r.emotion_value = "challenged" OR r.emotion_value = "hyped" THEN -1
                            WHEN r.emotion_value = "loading" THEN 0
                            ELSE 0 END) as upmood_meter')
                ->leftJoin('records as r',function($qry){
                    $qry->on('r.user_id', '=', 'u.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = u.id)'));
                })
                ->groupBy('country')
                ->orderBy('country','asc')
                ->get();


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
      $res = DB::table('contact_message')
        ->select('contact_message.content','contact_message.email','users.name','contact_message.created_at','contact_message.type')
        ->leftjoin('users',function($query){
          $query->on('users.id','=','contact_message.user_id');
        })
        ->orderBy('created_at','DESC')
        ->limit(50)
        ->get();
      return $res;
    }
}
