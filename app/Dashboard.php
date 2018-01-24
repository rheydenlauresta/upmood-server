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
      $res = DB::table('contact_message')->orderBy('created_at','DESC')->limit(50)->get();
      return $res;
    }
}
