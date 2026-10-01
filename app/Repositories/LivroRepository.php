<?php

namespace App\Repositories;

use App\Models\Livro;

class LivroRepository extends BaseRepository
{
    protected string $model = Livro::class;

    public function all()
    {
        return Livro::with(['autor', 'categoria'])->get();
    }

    public function find($id)
    {
        return Livro::with(['autor', 'categoria'])->findOrFail($id);
    }
}
