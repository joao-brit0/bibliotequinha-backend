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
}
