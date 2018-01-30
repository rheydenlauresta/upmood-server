<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;

use App\RestModel\Feature;

class FeaturedController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $featuredList = Feature::ListAll();

        return json_encode($featuredList);
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
        $validator = $this->validator(request()->all(), [
            'friend_id'              => 'required|integer',
        ], 'featured-friends');

        if($validator['status'] == 422) return json_encode($validator);

        $featured = Feature::store();

        return response()->json(array_merge($validator, $featured));
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
    public function update(Request $request, $module)
    {
        $checker = $this->methodCheck($module, [
           'remove'
        ], 'featured-update');

        if($checker['status'] == 204) return $checker;

        $result = $this->$module();

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function remove()
    {
        //
        $validator = $this->validator(request()->all(), [
            'friend_id'  => 'required',

        ], 'remove-featured');

        if($validator['status'] == 422) return json_encode($validator);

        $group = Feature::remove();

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'removed-featured',
            'errors'   => (Object) [],
        ]);
    }

    /**
     * Search friend to add in the group.
     */
    public function search()
    {
        $friends = request()->user()->featuredList();

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'group-search',
            'errors'   => (Object) [],
            'data'     => $friends->toArray(),
        ]);

    }
}
