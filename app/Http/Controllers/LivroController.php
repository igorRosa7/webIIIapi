<?php

namespace App\Http\Controllers;

use App\Services\LivroService;
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

    public function __construct(private LivroService $service) {}

    public function index()
    {
        return $this->service->listar();
    }

    public function show($id)
    {
        return $this->service->buscar($id);
    }

    public function store(Request $request)
    {
        $livro = $this->service->criar($request->validate($this->regras));

        return response()->json($livro, 201);
    }

    public function update(Request $request, $id)
    {
        return $this->service->atualizar($id, $request->validate($this->regras));
    }

    public function destroy($id)
    {
        $this->service->excluir($id);

        return response()->noContent();
    }
}
