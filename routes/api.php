<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Autenticação
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Consultas (GET) são públicas
Route::apiResource('autores', AutorController::class)->only(['index', 'show'])->parameters(['autores' => 'id']);
Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show'])->parameters(['categorias' => 'id']);
Route::apiResource('livros', LivroController::class)->only(['index', 'show'])->parameters(['livros' => 'id']);

// Cadastro, alteração e exclusão exigem token (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'me']);

    Route::apiResource('autores', AutorController::class)->except(['index', 'show'])->parameters(['autores' => 'id']);
    Route::apiResource('categorias', CategoriaController::class)->except(['index', 'show'])->parameters(['categorias' => 'id']);
    Route::apiResource('livros', LivroController::class)->except(['index', 'show'])->parameters(['livros' => 'id']);

    // Usuários: o cadastro é o POST /api/register
    Route::apiResource('users', UserController::class)->except(['store'])->parameters(['users' => 'id']);
});
