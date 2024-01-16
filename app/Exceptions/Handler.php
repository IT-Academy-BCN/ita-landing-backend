<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        //to keep a log for errors
        Log::error($exception);

        switch (true) {
            case $exception instanceof ModelNotFoundException:
                return response()->json(['error' => ['message' => trans('http-statuses.404')]], 404);
                break;
            case $exception instanceof ValidationException:
                return response()->json(['error' => ['message' => trans('http-statuses.422')]], 422);
                break;
            case $exception instanceof HttpException:
                return response()->json([
                    'error' => [
                        'message' => trans('http-statuses.'.$exception->status),
                    ],
                ], $exception->status);
                break;

            default:
                return parent::render($request, $exception);
        }
    }
}
