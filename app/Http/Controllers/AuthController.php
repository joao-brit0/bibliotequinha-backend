<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'user' => Auth::user() // Opcional: já devolver os dados do usuário
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401); 
    }
}
