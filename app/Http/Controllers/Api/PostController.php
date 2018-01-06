<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\Post;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = request()->user()->posts(10);

        return response()->json([
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'   => 'user-posts',
            'errors'   => (Object) [],
            'data'     => $post->toArray(),
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
            'content'  => 'required',
        ], 'store-post');

        if($validator['status'] == 422) return json_encode($validator);

        $post = Post::store();

        return response()->json(array_merge($validator, $post));

    }

}
