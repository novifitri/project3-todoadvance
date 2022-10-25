<?php

namespace App\Repositories;

use App\Models\User;
use InvalidArgumentException;

class AuthRepository 
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($credentials)
    {
        $token = auth()->attempt($credentials);
        return $token;
    }

    public function register(array $data)
    {
        $newUser = new $this->user;
        $newUser->name = $data["name"];
        $newUser->email = $data["email"];
        $newUser->password = bcrypt($data["password"]);
        $newUser->save();
        return $newUser->fresh();
    }
}