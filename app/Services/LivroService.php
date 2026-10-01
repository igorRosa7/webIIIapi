<?php

namespace App\Services;

use App\Repositories\LivroRepository;

class LivroService
{
    public function __construct(private LivroRepository $repository) {}

    public function listar()
    {
        return $this->repository->all();
    }

    public function buscar($id)
    {
        return $this->repository->find($id);
    }

    public function criar(array $dados)
    {
        return $this->repository->create($dados)->load(['autor', 'categoria']);
    }

    public function atualizar($id, array $dados)
    {
        return $this->repository->update($this->repository->find($id), $dados)->load(['autor', 'categoria']);
    }

    public function excluir($id): void
    {
        $this->repository->delete($this->repository->find($id));
    }
}
