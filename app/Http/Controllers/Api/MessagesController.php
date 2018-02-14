<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\Message;
use App\Events\MessageRecieved;

class MessagesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = $this->validator(request()->all(), [
            'email'           => 'required',
            'type'           => 'required',
            'content'           => 'required',

        ], 'store-messages');

        if($validator['status'] == 422) return json_encode($validator);

        $group = Message::store();

        // socket
        $notifications = Message::where('seen',0)
            ->leftJoin('users',function($query){
                $query->on('users.id','=','contact_message.user_id');
            })
            ->selectraw("contact_message.id, users.image, users.name, contact_message.type, content, DATE_FORMAT(contact_message.created_at, '%Y-%m-%d') as date_created, DATE_FORMAT(contact_message.created_at, '%r') as time_created")
            ->orderBy('contact_message.id','DESC')
            ->paginate(10);

        event( new MessageRecieved( 'notification', $notifications ) );
        // /socket

        return response()->json(array_merge($validator, $group));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
