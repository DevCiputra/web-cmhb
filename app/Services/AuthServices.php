<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function getAll()
    {
        return User::all();
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $wo = User::findOrFail($id);
        $wo->update($data);
        return $wo;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}
