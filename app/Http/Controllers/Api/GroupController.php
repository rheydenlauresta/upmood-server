<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\Group;
use App\RestModel\UserGroup;
use App\RestModel\Connection;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = request()->user()->groups();

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'user-posts',
            'errors'   => (Object) [],
            'data'     => $groups->toArray(),
        ]);
    }

    /**
     * Search friend to add in the group.
     */
    public function search()
    {
        $friends = request()->user()->connectionList();

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'group-search',
            'errors'   => (Object) [],
            'data'     => $friends->toArray(),
        ]);

    }

    /**
     * Add friend to the group.
     */
    public function addToGroup()
    {
        $validator = $this->validator(request()->all(), [
            'friend_id'          => 'required',
            'group_id'           => 'required',

        ], 'add-to-group');

        if($validator['status'] == 422) return json_encode($validator);

        $group = UserGroup::store();

        return response()->json(array_merge($validator, $group));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator(request()->all(), [
            'name'              => 'required',
            'emotion'           => 'required|in:0,1',
            'heartbeat'         => 'required|in:0,1',
            'stress_level'      => 'required|in:0,1',
            'my_mood'           => 'required|in:0,1',
            'notification_type' => 'required|in:time,minutes,emotions,live',
            'time'              => 'required_if:notification_type,time',
            'minutes'           => 'required_if:notification_type,minutes|nullable|in:5,10,30',
            'emotions'          => 'required_if:notification_type,emotions',
        ], 'store-group');

        if($validator['status'] == 422) return json_encode($validator);

        $group = Group::store();

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
        $groups = request()->user()->groups($id);
        
        return response()->json([
            'status'  => count($groups) > 0 ? (int) env('SUCCESS_RESPONSE_CODE') : (int) env('EMPTY_RESPONSE_CODE'),
            'message' => count($groups) > 0 ? 'success' : 'No Record Found!',
            'module'  => 'user-posts',
            'errors'  => (Object) [],
            'data'    => count($groups) > 0 ? $groups->toArray() : [],
        ]);
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
