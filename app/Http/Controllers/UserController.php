<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service) {}

    public function index()
    {
        return $this->service->listar();
    }

    public function show($id)
    {
        return $this->service->buscar($id);
    }

    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
        ]);

        return $this->service->atualizar($id, $dados, $request->user());
    }

    public function destroy(Request $request, $id)
    {
        $this->service->excluir($id, $request->user());

        return response()->noContent();
    }
}
