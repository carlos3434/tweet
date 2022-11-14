<?php

namespace App\Http\Resources\Auth\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserForLogin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => new User($this),
            'token' => $this->createToken('AppName')->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(Carbon::now()->addMinutes(6))->toDateTimeString(),
        ];
    }
}
