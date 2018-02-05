<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\Reaction, App\RestModel\User;

class ReactionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reaction = request()->user()->reactions('own', 10);

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'user-reactions',
            'errors'   => (Object) [],
            'data'     => $reaction->toArray(),
        ]);
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
            'id'                   => 'required',
            // 'heartbeat_count'      => 'required',
            // 'emoji_resource_id'    => 'required',
            'post_id'              => 'required',
            'reaction_resource_id' => 'required',
            'record_id' => 'required',
        ], 'send-reaction');

        if($validator['status'] == 422) return json_encode($validator);

        $react = Reaction::send();

        return response()->json(array_merge($validator, $react));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reaction = User::find($id);

        return response()->json([
            'status'   => isset($reaction->id) ? (int) env('SUCCESS_RESPONSE_CODE') : (int) env('EMPTY_RESPONSE_CODE'),
            'message' => isset($reaction->id) ? 'success' : 'No Record Found',
            'module'   => 'user-reactions',
            'errors'   => (Object) [],
            'data'     => isset($reaction->id) ? $reaction->reactions('other', 10)->toArray() : (Object) [],
        ]);
    }

}
