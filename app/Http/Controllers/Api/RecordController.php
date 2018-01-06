<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\Record, App\RestModel\User;

class RecordController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(null !== request('sort')){

            $type = request('sort') == 'date' ? request('date') : request('sort');

            $record = Record::sort($type);

        }else{

            $record = request()->user()->records();

        }

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'user-records',
            'errors'   => (Object) [],
            'data'     => $record->toArray(),
        ]);
        
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
            'heartbeat_count' => 'required',
            'resources_id'    => 'required',
            'stress_level'    => 'required',
            'type'            => 'required|in:automated,manual',
        ], 'store-record');

        if($validator['status'] == 422) return json_encode($validator);

        $record = Record::store();

        return response()->json(array_merge($validator, $record));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(null !== request('sort')){

            $type = request('sort') == 'date' ? request('date') : request('sort');

            $record = Record::sort($type, $id);

        }else{

            $record = User::find($id)->records();

        }

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'user-records',
            'errors'   => (Object) [],
            'data'     => $record->toArray(),
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
