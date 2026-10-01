<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected string $model = User::class;

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
