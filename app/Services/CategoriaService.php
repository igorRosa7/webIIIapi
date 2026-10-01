<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService
{
    public function __construct(private CategoriaRepository $repository) {}

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
        $categoria = $this->repository->find($id);

        if ($categoria->livros()->exists()) {
            abort(409, 'Não é possível excluir uma categoria que possui livros cadastrados.');
        }

        $this->repository->delete($categoria);
    }
}
