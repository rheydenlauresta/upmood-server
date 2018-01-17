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
      $data = ['users_activity'=>$userActivity, 'countries'=>$countryCount];
      // dd($data);
      return view('home',['users_activity'=>$userActivity, 'countries'=>$countryCount]);
      // return json_encode($data);
    }

     public function usersList()
     {
        $data = Dashboard::getUsers();
        $filter = ['','Activity level','Name','Location','Gender','Age','Current Emotion','Status'];

        return view('users',['results' => $data, 'filters'=>$filter]);
     }

     public function userFilter(Request $request)
     {
        $res = Dashboard::searchFilter($request);
     }

     public function userCountry()
     {
       $data = Dashboard::getUserCountry();
       return json_encode($data);
     }


}
