<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\User;

class ProfileController extends BaseController
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $viewer = User::viewOthers($id);

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'view-friends',
            'errors'   => (Object) [],
            'data'     => $viewer,
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
    public function update(Request $request, $module)
    {
        // VALIDATE REQUEST METHOD REQUIREMENTS

        $checker = $this->methodCheck($module, [
            'status', 'basicEmoji','isOnline'
        ], 'profile-update');

        if($checker['status'] == 204) return $checker;

        $result = $this->$module();

        return response()->json($result);

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

    public function status()
    {
        // VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator(request()->all(), [
            'status'      => 'required|integer|in:0,1,2,3',
        ], 'change-status');

        if($validator['status'] == 422) return $validator;

        $status = User::status();

        return array_merge($validator, $status);
        
    }

    public function basicEmoji()
    {
        // VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator(request()->all(), [
            'set_name'      => 'required',
        ], 'change-basic-emoji');

        if($validator['status'] == 422) return $validator;

        $emoji = User::basicEmoji();

        return array_merge($validator, $emoji);

    }

    public function isOnline()
    {
        // VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator(request()->all(), [
            'is_online'      => 'required',
        ], 'change-online-status');

        if($validator['status'] == 422) return $validator;

        $online = User::isOnline();

        return array_merge($validator, $online);

    }
}
