<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;

class UsersController extends Controller
{
    public function usersList()
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

    public function userFilter(Request $request)
    {
        $data = Input::all();
        
        $res = [];

        $res['content'] = User::searchFilter($data);
        $res['counts'] = User::advCardCounts($data);

        return $res;
    }
}
