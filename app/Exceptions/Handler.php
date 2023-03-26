<?php

namespace App\Exceptions;

use App\Constants\ErrorCodes;
use App\Http\Responses\Backend\ErrorResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    public function render($request, Exception|Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($e instanceof ModelNotFoundException && $request->wantsJson()) {
            return new ErrorResponse(
                message: __("Model not found!"),
                code: -10001,
                file: $e->getFile(),
                line: $e->getLine(),
                status: 404
            );
        }

        if ($e instanceof NotFoundHttpException && $request->wantsJson()) {
            return new ErrorResponse(
                message: __("Route not found!"),
                code: -10001,
                file: $e->getFile(),
                line: $e->getLine(),
                status: 404
            );
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
