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
       // $search = Input::get('search');
       // dd($_GET['search']);
       if(isset($_GET['search']))
       {
         $search = $_GET['search'];
         $data = Dashboard::searchFilter($search);

         // dd($data);
       }
       else {
         $data = Dashboard::getUsers();

       }

        $country = Dashboard::getUserCountry();
        $filter = ['','is_active'   =>'Activity level',
                    'name'          =>'Name',
                    'country'       =>'Location',
                    'gender'        =>'Gender',
                    'age'           =>'Age',
                    'emotion'       =>'Current Emotion',
                    'profile_post'  =>'Status'];

        return view('userlist',['results' => $data, 'filters'=>$filter, 'countries'=>$country]);
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
