<?php

namespace App\Services;

use App\Repositories\AutorRepository;

class AutorService
{
    public function __construct(private AutorRepository $repository) {}

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
        return $this->repository->create($dados);
    }

    public function atualizar($id, array $dados)
    {
        return $this->repository->update($this->repository->find($id), $dados);
    }

    public function excluir($id): void
    {
        $autor = $this->repository->find($id);

        if ($autor->livros()->exists()) {
            abort(409, 'Não é possível excluir um autor que possui livros cadastrados.');
        }

        $this->repository->delete($autor);
    }
}
