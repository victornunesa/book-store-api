<?php

use App\Http\Responses\ApiErrorResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $code = $e->status ?? null;

                if (empty($code)) {
                    if ($e instanceof NotFoundHttpException) {
                        $code = Response::HTTP_NOT_FOUND;
                    } elseif ($e instanceof AuthenticationException) {
                        $code = Response::HTTP_UNAUTHORIZED;
                    } elseif ($e instanceof ValidationException) {
                        $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                    } else {
                        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                    }
                }

                return new ApiErrorResponse($e, $e->getMessage(), $code);
            }

            return $request->expectsJson();
        });
    })->create();
