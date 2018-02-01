<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Message;
use App\Reply;
use App\SentMessage;

class MessagesController extends Controller
{

	function __construct(){
        #title panels
        $this->title   = 'Message';
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
        
    }

    public function show($module)
    {

        return $this->$module();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $module)
    {
        $result = $this->$module();
    }

    public function destroy($id)
    {
        //
    }

    public function getMessages(){
        $data = Input::all();

    	$messages = Message::selectraw("contact_message.id, users.name, contact_message.type, content, DATE_FORMAT(contact_message.created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(contact_message.created_at, '%r') as time_created")
	    	->leftjoin('users',function($query){
	    		$query->on('users.id','=','contact_message.user_id');
	    	});

	    	if($data['type'] != ''){
				$messages = $messages->where('type',$data['type']);
	    	}

	    	if($data['search'] != '' && $data['search'] != null){
				$messages = $messages->where(function($query) use($data){
					$query->where('users.name','like','%'.$data['search'].'%');
					$query->orWhere('contact_message.type','like','%'.$data['search'].'%');
					$query->orWhere('content','like','%'.$data['search'].'%');
				});
	    	}

	    $messages = $messages->orderBy('contact_message.id', 'DESC')
	    	->get();

    	return $messages->toArray();
    }

    public function getReplies(){
        $data = Input::all();

    	$replies = Reply::selectraw("message, DATE_FORMAT(created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(created_at, '%r') as time_created")
    				->where('contact_message_id',$data['id'])
    				->get();

    	return $replies->toArray();
    }

    public function sendReply(){
        $data = Input::all();

        $res = $this->get_store($data,new Reply());
        ////////////////// email //////////////////// 

        return $res;
    }

    public function sendMessage(){
        $data = Input::all();
print_r($data);
        foreach($data['emailArray'] as $key => $value){
        	$data['email'] = $value;
        	$res = $this->get_store($data,new SentMessage());
        }

        ////////////////// email //////////////////// 

        return $res;
    }
}
