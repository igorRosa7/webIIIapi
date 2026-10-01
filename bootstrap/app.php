<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Erros (404, 422 de validação etc.) das rotas /api sempre em JSON
        $exceptions->shouldRenderJsonWhen(fn ($request) => $request->is('api/*'));

        // Erros HTTP (401, 403, 404, 409...) retornam só a mensagem, sem detalhes internos
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $mensagem = $e->getStatusCode() === 404 ? 'Não encontrado.' : $e->getMessage();

                return response()->json(['message' => $mensagem], $e->getStatusCode());
            }
        });
    })->create();
