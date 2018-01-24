<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Dashboard;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $userActivity = Dashboard::userActivityCount();
      $countryCount = Dashboard::countryCount();
      $contactInqueries = Dashboard::getContactForm();

      return view('home',['users_activity'=>$userActivity,
                            'countries'=>$countryCount,
                            'inquiries'=>$contactInqueries]);
      }

     public function usersList()
     {

        $data = Input::all();

        $result = Dashboard::searchFilter($data);
        $country = Dashboard::getUserCountry();

        return view('userslist',['results' => $result, 'countries'=>$country->toArray()]);
     }

     public function userFilter(Request $request)
     {
        $data = Input::all();

        $res = Dashboard::searchFilter($data);

        return $res;
     }

     public function userInfo($id)
     {
       $info = Dashboard::getUserInfo($id);
       $moodRecords = Dashboard::getUserMood($id);


       return view('profile',['info' => $info, 'moods'=>$moodRecords]);
     }
}
