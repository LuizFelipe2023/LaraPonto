<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function index()
    {
        return User::orderBy('tipo_usuario')->get();
    }

    public function getAllUsers()
    {
           return User::all();
    }

    public function findUserById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function returnAllManagers()
    {
           return User::where('tipo_usuario',2)->orderBy('name')->get();
    }

    public function insertUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tipo_usuario' => $data['tipo_usuario'],
        ]);
    }

    public function updateUser(int $id, array $data): User
    {
        $user = $this->findUserById($id);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'tipo_usuario' => $data['tipo_usuario'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return $user;
    }

    public function destroyUser(int $id): bool
    {
        $user = $this->findUserById($id);
        return $user->delete();
    }
}
