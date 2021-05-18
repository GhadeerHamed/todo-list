<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
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
    }


    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()){
            if ($e instanceof ModelNotFoundException) {
                return  response()->json([
                    'result' => 'error',
                    'content' => null,
                    'error_des' => 'Item Not Found',
                    'error_code' => 1,
                    'date' =>Carbon::now()
                ],404);
            }

            if ($e instanceof ValidationException) {
                return  response()->json([
                    'result' => 'error',
                    'content' => null,
                    'error_des' => $e->validator->errors()->first(),
                    'error_validation' => $e->validator->errors(),
                    'error_code' => 1,
                    'date' =>date('Y-m-d')
                ],400);
            }
        }

        return parent::render($request, $e);
    }
}
