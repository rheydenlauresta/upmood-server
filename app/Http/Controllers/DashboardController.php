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
      $contactMessages = Dashboard::getContactForm();

      return view('home',['users_activity'=>$userActivity,
                            'countries'=>$countryCount,
                            'messages'=>$contactMessages]);
      }

     public function userInfo($id)
     {
       $info = Dashboard::getUserInfo($id);
       $moodRecords = Dashboard::getUserMood($id);


       return view('profile',['info' => $info, 'moods'=>$moodRecords]);
     }
}
