<?php

namespace App\Services\Auth;

use App\Http\Data\Api\Auth\RegisterData;
use App\Models\User;

class AuthService
{
    public function registerUser(RegisterData $data): User
    {
        $user = User::create($data->all());
        // $organizer->assignRole($organizerRole);

        return $user;
    }
}
