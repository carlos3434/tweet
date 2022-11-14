<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFollow;
use App\Http\Requests\UpdateFollow;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{

    public function followTosomeone(StoreFollow $request)
    {
        $all = $request->all();
        $all['followed_id'] = Auth::id();
        $follow = Follow::create($all);
        return response()->json($follow, 201);
    }

    public function followersCount()
    {
        $followsCount = Follow::where('followed_id', Auth::id())->count();
        return response()->json(['followersCount' => $followsCount], 200);
    }
    public function followingsCount()
    {
        $followingsCount = Follow::where('follower_id', Auth::id())->count();
        return response()->json(['followingsCount' => $followingsCount], 200);
    }
}
