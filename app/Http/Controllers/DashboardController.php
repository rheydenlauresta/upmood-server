<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

       if(isset($_GET['search']))
       {
         $search = $_GET['search'];
         $data = Dashboard::searchFilter($search);
       }
       else {
         $data = Dashboard::getUsers();
       }

        // dd($data);
        $country = Dashboard::getUserCountry();

        return view('userslist',['results' => $data, 'countries'=>$country]);
     }

     public function userFilter(Request $request)
     {
        $res = Dashboard::searchFilter($request);
        return $res;
     }

     public function userInfo($id)
     {
       $info = Dashboard::getUserInfo($id);
       $moodRecords = Dashboard::getUserMood($id);


       return view('profile',['info' => $info, 'moods'=>$moodRecords]);
     }
}
