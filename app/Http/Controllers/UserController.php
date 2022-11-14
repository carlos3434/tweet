<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreUser;
use App\Http\Requests\Auth\UpdateUser;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(StoreUser $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(UpdateUser $request, User $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
