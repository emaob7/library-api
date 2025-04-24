<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
            // Configure reporting if needed
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return $this->handleApiException($e);
            }
        });
    }

    /**
 * Convert an authentication exception into a response.
 */
protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated',
            'errors' => [
                'auth' => ['Authentication token is missing or invalid']
            ]
        ], Response::HTTP_UNAUTHORIZED); // 401
    }
    /**
     * Handle API exceptions with consistent JSON responses
     */
    protected function handleApiException(Throwable $e): Response
    {
        return match (true) {
            $e instanceof ModelNotFoundException => response()->json([
                'message' => 'Resource not found',
                'errors' => ['resource' => ['The requested resource does not exist']],
            ], Response::HTTP_NOT_FOUND),

            $e instanceof ValidationException => response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY),

            $e instanceof NotFoundHttpException => response()->json([
                'message' => 'Endpoint not found',
                'errors' => ['route' => ['The requested API endpoint does not exist']],
            ], Response::HTTP_NOT_FOUND),

            $e instanceof MethodNotAllowedHttpException => response()->json([
                'message' => 'Method not allowed',
                'errors' => ['method' => ['The HTTP method is not supported for this endpoint']],
            ], Response::HTTP_METHOD_NOT_ALLOWED),

            $e instanceof AuthenticationException => response()->json([
                'message' => 'Unauthenticated',
                'errors' => ['auth' => ['Authentication is required to access this resource']],
            ], Response::HTTP_UNAUTHORIZED),

            default => response()->json([
                'message' => 'Server Error',
                'errors' => ['server' => [config('app.debug') ? $e->getMessage() : 'An unexpected error occurred']],
            ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }
}