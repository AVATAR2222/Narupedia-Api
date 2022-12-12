<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class AuthController extends Controller
{
    #[ArrayShape(['token' => "mixed"])]
    public function register(RegisterRequest $registerRequest): array
    {
        $user = User::query()->create([
            'username' => $registerRequest->get('username'),
            'email' => $registerRequest->get('email'),
            'avatar_file_name' => $registerRequest->get('avatar_file_name'),
            'password' => Hash::make($registerRequest->get('password'))
        ]);

        $token = $user->createToken('api');

        return ['token' => $token->plainTextToken];
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $loginRequest)
    {
        $user = User::query()->where('email', $loginRequest->get('email'))->first();

        if (!$user or !Hash::check($loginRequest->get('password'), $user->password)) {
            return new Response(['auth' => ['The provided credentials are incorrect.']],422);
        }

        return ['token' => $user->createToken('api')->plainTextToken];
    }
}
