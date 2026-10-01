<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected string $model;

    public function all()
    {
        return $this->model::all();
    }

    public function find($id)
    {
        return $this->model::findOrFail($id);
    }

    public function create(array $dados)
    {
        return $this->model::create($dados);
    }

    public function update(Model $registro, array $dados)
    {
        $registro->update($dados);

        return $registro;
    }

    public function delete(Model $registro): void
    {
        $registro->delete();
    }
}
