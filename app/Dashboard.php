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

    public static function getUsers()
    {
        $res = DB::table('users as u')
                    ->selectRaw('MAX(r.id) AS record_id,u.image, u.name, u.gender,
                                u.age, u.country, r.heartbeat_count, u.profile_post,
                                if(u.is_online,"online","offline") as active_level,r.emotion_value')
                    ->leftJoin('records as r','u.id','r.user_id')
                    ->groupBy('name')
                    ->paginate(10);

        return $res;
    }

    public static function searchFilter($request)
    {
        // select * from users where filter = subFilter
        $res = DB::table('users as u')
                ->leftJoin('records as r', 'u.id','r.user_id')
                ->where($request->filter, $request->subfilter)
                ->orWhere('name','like',$request->search,'%')
                ->paginate(10);

        return $res;
    }

    public static function getUserCountry()
    {
      $res = DB::table('users')->groupBy('country')->get();
      return $res;
    }
}
