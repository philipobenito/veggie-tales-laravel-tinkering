<?php

namespace App\Handlers;

use App\Enums\HttpStatus;
use Illuminate\Foundation\Exceptions\Handler as BaseExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class ExceptionHandler extends BaseExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Because the app is purely an API we'll treat all exceptions as JSON
        return $this->handleJsonException($request, $exception);
    }

    /**
     * Handle JSON exceptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleJsonException($request, Throwable $exception): JsonResponse
    {
        $status = HttpStatus::HTTP_INTERNAL_SERVER_ERROR;
        $message = null;

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $status = HttpStatus::HTTP_BAD_REQUEST;
            $message = $exception->errors();
        } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $status = HttpStatus::HTTP_UNAUTHORIZED;
        } elseif ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $status = HttpStatus::HTTP_FORBIDDEN;
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $status = HttpStatus::HTTP_NOT_FOUND;
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $status = $exception->getStatusCode();
            $message = $exception->getMessage();
        }

        return response()->json([
            'error' => [
                'message' => $message ?? HttpStatus::getMessage($status),
                'status' => $status,
                'exception' => $exception->getMessage(),
            ]
        ], $status);
    }
}
