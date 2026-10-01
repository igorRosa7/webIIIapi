<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;

Route::apiResource('autores', AutorController::class)->parameters(['autores' => 'id']);
Route::apiResource('categorias', CategoriaController::class)->parameters(['categorias' => 'id']);
Route::apiResource('livros', LivroController::class)->parameters(['livros' => 'id']);
