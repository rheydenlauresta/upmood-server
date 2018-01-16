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
        $res = DB::table('users')->selectRaw('country, count(*) as user_number')
                    ->groupBy('country')->get();

        return $res;
    }

    public static function getUsers()
    {
        $res = DB::table('users')->paginate(10);

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
}
