<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Message;
use App\Reply;
use App\SentMessage;
use App\Jobs\MessageResponse;
use App\Jobs\MessageCreate;

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

    public function getMessages(){ // Get Messages
        $data = Input::all();

        if($data['type'] == 'sentMessage'){
        	return $this->getSentmessage();
        }

    	$messages = Message::selectraw("contact_message.id, users.image, users.name, contact_message.type, content, DATE_FORMAT(contact_message.created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(contact_message.created_at, '%r') as time_created")
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
	    	->paginate(10);

    	return $messages->toArray();
    }

    public function getReplies(){ // Get Messages Replies
        $data = Input::all();

    	$replies = Reply::selectraw("message, DATE_FORMAT(created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(created_at, '%r') as time_created")
    				->where('contact_message_id',$data['id'])
    				->get();

    	return $replies->toArray();
    }

    public function getSentmessage(){ // Get Send Messages
        $data = Input::all();

    	$sentMessages = SentMessage::selectraw("subject, message,GROUP_CONCAT(email) as emails, DATE_FORMAT(created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(created_at, '%r') as time_created")
    				->orderBy('id', 'DESC')
    				->groupBy('batch')
    				->get();

    	return $sentMessages->toArray();
    }

    public function emailSearch(){ // Get Available emails
        $data = Input::all();

    	$emails = User::selectraw("name, image, email")
    				->where(function($query) use($data){
    					$query->orWhere('email','like','%'.$data['email'].'%');
    					$query->orWhere('name','like','%'.$data['email'].'%');
    				})
    				->take(10)
    				->get();


    	return $emails->toArray();
    }

    public function sendReply(){ // Send Messages Replies
        $data = Input::all();
        $record = Message::find($data['contact_message_id']);

        $validator = $this->validatorCms(Input::all(), [
            'message'           => 'required',
        ]);

        if($validator['status'] == 422){
        	return false;
        }else{
            $res = $this->get_store($data,new Reply());
            $data['email'] = $record->email;

           	dispatch(new MessageResponse($data));

            return $res;
        } 

    }

    public function sendMessage(){ // Send Compose Messages
        $data = Input::all();

        $last_batch = SentMessage::selectraw('max(batch) as batch')->first();
        $data['batch'] = $last_batch->batch + 1;
        if(count($data['emailArray']) == 0){
            return false;
        }
        $validator = $this->validatorCms(Input::all(), [
            'subject'           => 'required',
            'message'           => 'required',
        ]);

        if($validator['status'] == 422){
            return false;
        }else{
            foreach($data['emailArray'] as $key => $value){
                $data['email'] = $value;

            	$res = $this->get_store($data,new SentMessage());

           		dispatch(new MessageCreate($data));

            }
        } 


        return $res;
    }
}
