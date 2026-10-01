<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    private array $regras = [
        'nome' => 'required|string|max:45',
        'nacionalidade' => 'nullable|string|max:45',
        'nascimento' => 'nullable|date',
        'biografia' => 'nullable|string',
    ];

    public function index()
    {
        return Autor::all();
    }

    public function show($id)
    {
        return Autor::findOrFail($id);
    }

    public function store(Request $request)
    {
        $autor = Autor::create($request->validate($this->regras));

        return response()->json($autor, 201);
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);
        $autor->update($request->validate($this->regras));

        return $autor;
    }

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);

        if ($autor->livros()->exists()) {
            return response()->json(['message' => 'Não é possível excluir um autor que possui livros cadastrados.'], 409);
        }

        $autor->delete();

        return response()->noContent();
    }
}
