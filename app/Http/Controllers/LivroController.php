<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    private array $regras = [
        'titulo' => 'required|string|max:255',
        'isbn' => 'nullable|string|max:45',
        'anopublicacao' => 'nullable|integer',
        'descricao' => 'nullable|string|max:255',
        'paginas' => 'nullable|integer|min:1',
        'idautor' => 'required|integer|exists:autor,idautor',
        'idcategoria' => 'required|integer|exists:categoria,idcategoria',
    ];

    public function index()
    {
        return Livro::with(['autor', 'categoria'])->get();
    }

    public function show($id)
    {
        return Livro::with(['autor', 'categoria'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $livro = Livro::create($request->validate($this->regras));

        return response()->json($livro->load(['autor', 'categoria']), 201);
    }

    public function update(Request $request, $id)
    {
        $livro = Livro::findOrFail($id);
        $livro->update($request->validate($this->regras));

        return $livro->load(['autor', 'categoria']);
    }

    public function destroy($id)
    {
        Livro::findOrFail($id)->delete();

        return response()->noContent();
    }
}
