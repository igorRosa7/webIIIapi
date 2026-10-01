<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private array $regras = [
        'nome' => 'required|string|max:45',
        'descricao' => 'nullable|string|max:255',
    ];

    public function index()
    {
        return Categoria::all();
    }

    public function show($id)
    {
        return Categoria::findOrFail($id);
    }

    public function store(Request $request)
    {
        $categoria = Categoria::create($request->validate($this->regras));

        return response()->json($categoria, 201);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->validate($this->regras));

        return $categoria;
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->livros()->exists()) {
            return response()->json(['message' => 'Não é possível excluir uma categoria que possui livros cadastrados.'], 409);
        }

        $categoria->delete();

        return response()->noContent();
    }
}
