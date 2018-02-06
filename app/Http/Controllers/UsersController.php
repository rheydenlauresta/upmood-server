<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $data = Input::all();

        $results = User::searchFilter($data);
        $countries = User::getCountryList();
        $emotions = User::getEmotionList();

        return view('userslist',[
			'results' => $results, 
			'countries'=>$countries->toArray(),
			'emotions'=>$emotions->toArray(),
        ]);
    }

    public function show($module)
    {
        $checker = $this->methodCheckCms($module, [
           'userFilter', 'userProfile'
        ]);

        if($checker['status'] == 204) return $checker;

        return $this->$module();
    }

    public function update(Request $request, $module)
    {

        $checker = $this->methodCheckCms($module, [
           'userFilter', 'userProfile'
        ]);

        if($checker['status'] == 204) return $checker;

        $result = $this->$module();
    }

    public function userFilter()
    {
        $data = Input::all();
        
        $res = [];

        $res['content'] = User::searchFilter($data);
        $res['counts'] = User::advCardCounts($data);

        return $res;
    }

    public function userProfile($id)
    {
        $data = Input::all();

        $profile = User::getProfile($id);
        $records = User::getRecords($id);
        $featured = User::getFeatured($id);
        // dd($featured->toArray());
        return view('userprofile',[
            'profile'=>$profile,
            'records'=>$records->toArray(),
            'featured'=>$featured->toArray()
        ]);

    }

    public function upmoodCalendar(){
        $data = Input::all();

        $upmood_calendar = User::getCalendar($data);
        // print_r($upmood_calendar->toArray());
        return $upmood_calendar->toArray();
    }
}
