<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Message;
use App\Reply;

class MessagesController extends Controller
{

	function __construct(){
        #title panels
        $this->title   = 'Message';
        $this->eloquentModel = new Reply();
        $this->controller    = $this;

    }

    public function index()
    {
        //
        return view('messages');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = Input::all();

        $res = $this->get_store($data,$this->eloquentModel);
        ////////////////// email //////////////////// 

        return $res;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function messages(){
        $data = Input::all();

    	$messages = Message::selectraw("contact_message.id, users.name, contact_message.type, content, DATE_FORMAT(contact_message.created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(contact_message.created_at, '%r') as time_created")
	    	->leftjoin('users',function($query){
	    		$query->on('users.id','=','contact_message.user_id');
	    	});

	    	if($data['type'] != ''){
				$messages = $messages->where('type',$data['type']);
	    	}

	    $messages = $messages->orderBy('contact_message.id', 'DESC')
	    	->get();

    	return $messages->toArray();
    }

    public function replies(){
        $data = Input::all();

    	$replies = Reply::selectraw("message, DATE_FORMAT(created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(created_at, '%r') as time_created")
    				->where('contact_message_id',$data['id'])
    				->get();

    	return $replies->toArray();
    }
}
