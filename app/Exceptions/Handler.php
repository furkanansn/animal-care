<?php

namespace App\Exceptions;

use App\Http\Traits\ReturnResponse;
use App\Models\Alert;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ReturnResponse;

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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });

    }

    public function render($request, \Exception|Throwable $e)
    {

        $alertData = [

            'msg'           => (string) $e?->getMessage() . ' => ' . request()?->url(),
            'code'          => (string) $e?->getCode(),
            'file'          => (string) $e?->getFile(),
            'line'          => (string) $e?->getLine(),
            'ip_address'    => $request->ip()

        ];

        Alert::create(array_merge($alertData, ['user_id' => $request->user()?->id]));

        if ($request->is('api/*')) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return $this->sendError('Aradığınız veri bulunamadı!');
            }

            if ($e instanceof QueryException) {
                return $this->sendError('Verileriniz veritabanı ile uyuşmuyor! Lütfen yöneticiyle görüşün!');
            }

            if ($e instanceof FileNotFoundException) {
                return $this->sendError('Belirtilen dosya bulunamadı!');
            }

            if ($e instanceof \Illuminate\Contracts\Filesystem\FileNotFoundException) {
                return $this->sendError('Belirtilen dosya bulunamadı!');
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->sendError('Bu route bu methodu desteklemiyor!', 500);
            }

            if ($e instanceof \Exception) {
                if ($e->getMessage() === '') {
                    return $this->sendError($e->getFile());
                }
                return $this->sendError($e->getMessage());
            }
        }

        return parent::render($request, $e);

    }
}
