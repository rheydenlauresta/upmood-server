<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function users()
    {
        return view('users');
    }

    public function test()
    {

        $data['email'] = 'rhey.taisondigital@gmail.com';
        $data['subject'] = 'email test';
        $data['message'] = 'testing content';

        dispatch(new MessageCreate($data));

        return $res;
    }

    // public function sample(){

    //     $user = User::simplePaginate(4);

    //     dd($user->toArray());

    // }
}
