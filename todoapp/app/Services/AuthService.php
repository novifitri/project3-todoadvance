<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login($credentials)
    {
        $token = $this->authRepository->login($credentials);
        if(!$token)
        {
            throw new InvalidArgumentException("Unauthorized");
        }
        return $token;
    }

    public function register(array $data)
    {
        $validator = Validator::make($data, [
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required"
        ]);
        //jika validasi gagal
        if($validator->fails())
        {
            throw new InvalidArgumentException(json_encode($validator->errors()));
        }
        $createdUser= $this->authRepository->register($data);
		return $createdUser;
    }
}