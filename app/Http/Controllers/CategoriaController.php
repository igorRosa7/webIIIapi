<?php

namespace App\Http\Controllers;

use App\Services\CategoriaService;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private array $regras = [
        'nome' => 'required|string|max:45',
        'descricao' => 'nullable|string|max:255',
    ];

    public function __construct(private CategoriaService $service) {}

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
        $categoria = $this->service->criar($request->validate($this->regras));

        return response()->json($categoria, 201);
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
