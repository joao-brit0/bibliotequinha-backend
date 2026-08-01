<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function createUser(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->userService->storeUser($validatedData);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401); 
    }
}
