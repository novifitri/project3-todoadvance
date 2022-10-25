<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(Request $request)
    {
        $credentials = $request->only(["email", "password"]);
        $result = ["statusCode" => 200];
        try{
            $result["access_token"] = $this->authService->login($credentials);
            $result["token_type"] = "Bearer";
            $result["expires_in"] = 60 * 60;
        }
        catch(Exception $e){
            $result = [
                "statusCode" => 401,
                "error" => $e->getMessage(),
            ];
        }
        return response()->json($result, $result["statusCode"]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(["message"=> "Sukses logout"], 200);
    }

    public function register(Request $request)
    {
        $data = $request->only(["name", "email", "password"]);
        $result = ["statusCode" => 200];

        try{
            $result["message"] = "Berhasil register";
            $result["data"] = $this->authService->register($data);
        }catch(Exception $e){
            $result = [
                "statusCode" => 400,
                "error" => json_decode($e->getMessage()),
            ];
        }
        return response()->json($result, $result["statusCode"]);

    }
    public function refresh()
    {
        return response()->json([
                "access_token" => auth()->refresh(),
                'token_type' => 'Bearer',
                'expires_in' => 60 * 60,
            ], 200);
    }

    public function data()
    {
        return response()->json(auth()->user());
    }
}
