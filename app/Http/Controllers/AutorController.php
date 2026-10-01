<?php

namespace App\Http\Controllers;

use App\Services\AutorService;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    private array $regras = [
        'nome' => 'required|string|max:45',
        'nacionalidade' => 'nullable|string|max:45',
        'nascimento' => 'nullable|date',
        'biografia' => 'nullable|string',
    ];

    public function __construct(private AutorService $service) {}

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
        $autor = $this->service->criar($request->validate($this->regras));

        return response()->json($autor, 201);
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
