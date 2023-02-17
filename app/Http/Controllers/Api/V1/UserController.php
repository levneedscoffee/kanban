<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Requests\V1\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedReq = $request->validated();

        $user = User::create([
            'name' => $validatedReq['name'],
            'email' => $validatedReq['email'],
            'password' => bcrypt($validatedReq['password'])
        ]);

//добавить проверку на существование
        $token = $user->createToken("{$$validatedReq['name']}")->plainTextToken();

        return [
            'user' => $user,
            'token' => $token
        ];
    }


    public function login(LoginRequest $request)
    {
        $validatedReq = $request->validated();

        $user = User::where('email', $validatedReq['email'])->first();

        if(!$user) {
            return response()->json(['message' => 'User with this email not found.'], 404);
        }

        if (!Hash::check($validatedReq['password'], $user->password)) {
            return response()->json(['message' => 'Password not right.'], 404);
        }

        //добавить проверку на существование
        $token = $user->createToken("{$user->name}")->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(Request $request)
    {
        return $request->user()->tokens()->delete();
    }
}
