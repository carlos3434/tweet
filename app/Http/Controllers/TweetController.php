<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweet;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::all();
        return response()->json($tweets);
    }

    public function store(StoreTweet $request)
    {
        $all = $request->all();
        $all['user_id'] = Auth::id();
        //$all = $this->storeFile($request, $all, 'capacitacion', 'certificado');
        //$capacitacion = $this->repository->create( $all );

        $tweet = Tweet::create($all);
        return $tweet;
    }
}
