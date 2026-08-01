<?php

namespace App\Services;
use App\Models\User;

class UserService
{
    public function storeUser($data)
    {
        // Cria um novo usuário com os dados fornecidos
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'] ?? 'user', // Define o papel do usuário, padrão é 'user'
        ]);

        return $user;
    }
}