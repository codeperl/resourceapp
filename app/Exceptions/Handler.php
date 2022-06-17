<?php

namespace App\Exceptions;

use App\Services\Concerns\Messages;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Messages;

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->ajax() && $request->acceptsJson()) {
                $contents = array_merge($this->failed('Validation failed.'), [
                    'data' => null,
                    'errors' => $e->errors(),
                ]);
                return response()->json($contents, 422);
            }
        });

        $this->renderable(function (LogicalExceptionable $e, $request) {
            //$request->acceptsJson();
            if ($request->acceptsJson()) {
                $contents = array_merge($this->failed("Logical error. {$e->getMessage()}"), [
                    'data' => null,
                    'errors' => [
                        'model' => [
                            $e->getMessage()
                        ]
                    ],
                ]);

                return response()->json($contents, 422);
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->ajax() && $request->acceptsJson()) {
                $contents = array_merge($this->failed('Valid auth credentials required.'), [
                    'data' => null,
                    'errors' => $e->getMessage(),
                ]);
                return response()->json($contents, 401);
            }

            return redirect()->guest('login');
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->ajax() && $request->acceptsJson()) {
                $contents = array_merge($this->failed('Not found.'), [
                    'data' => null,
                    'errors' => null,
                ]);
                return response()->json($contents, 404);
            }
        });
    }
}
