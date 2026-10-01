<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private UserRepository $repository) {}

    public function registrar(array $dados): array
    {
        $user = $this->repository->create($dados);

        return ['user' => $user, 'token' => $user->createToken('api')->plainTextToken];
    }

    public function login(string $email, string $senha): array
    {
        $user = $this->repository->findByEmail($email);

        if (! $user || ! Hash::check($senha, $user->password)) {
            abort(401, 'E-mail ou senha inválidos.');
        }

        return ['user' => $user, 'token' => $user->createToken('api')->plainTextToken];
    }
}
