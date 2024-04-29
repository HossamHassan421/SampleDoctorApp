<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 404,
                'message' => trans('system.page_not_found')
            ], 404);
        } elseif ($e instanceof ValidationException) {
            return response()->json([
                'status' => 400,
                'errors' => $e->errors()
            ], 400);
        } elseif ($e instanceof AuthenticationException) {
            return response()->json([
                'status' => 403,
                'message' => trans('system.unauthenticated')
            ], 403);
        } elseif ($e instanceof AuthorizationException) {
            return response()->json([
                'status' => 401,
                'message' => trans('system.unauthorized')
            ], 401);
        } else {
            $pathInfo = $request->getPathInfo();
            $message = $e->getMessage();
            Log::error("$message -@ $pathInfo");
            return response()->json([
                'status' => 500,
                'message' => trans('system.internal_server_error')
            ], 500);
        }
        return parent::render($request, $e);
    }
}
