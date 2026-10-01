<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private UserRepository $repository) {}

    public function listar()
    {
        return $this->repository->all();
    }

    public function buscar($id)
    {
        return $this->repository->find($id);
    }

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

    // Um usuário só pode alterar ou excluir a própria conta
    public function atualizar($id, array $dados, User $logado)
    {
        $user = $this->somenteProprio($id, $logado);

        if (empty($dados['password'])) {
            unset($dados['password']);
        }

        return $this->repository->update($user, $dados);
    }

    public function excluir($id, User $logado): void
    {
        $user = $this->somenteProprio($id, $logado);

        $user->tokens()->delete();
        $this->repository->delete($user);
    }

    private function somenteProprio($id, User $logado)
    {
        $user = $this->repository->find($id);

        if ($user->id !== $logado->id) {
            abort(403, 'Você só pode alterar ou excluir a sua própria conta.');
        }

        return $user;
    }
}
