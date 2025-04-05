<?php

use App\Modules\Transaction\Exceptions\InsufficientBalanceException;
use App\Modules\Transaction\Exceptions\ShopkeeperTransferException;
use App\Modules\Transaction\Exceptions\UnauthorizedTransferException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: [
            __DIR__ . '/../routes/api.php',
            __DIR__ . '/../app/Modules/User/routes/api.php',
            __DIR__ . '/../app/Modules/Transaction/routes/api.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InsufficientBalanceException $e, $request) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        });

        $exceptions->render(function (ShopkeeperTransferException $e, $request) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        });

        $exceptions->render(function (UnauthorizedTransferException $e, $request) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        });
    })->create();
