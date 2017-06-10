<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        //HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
//        if ($this->shouldReport($e)) {
//            $this->log->error([
//                'request_url'=>request()->fullUrl(),
//                'message' => $e->getMessage(),
//                'code' => $e->getCode(),
//                'file' => $e->getFile(),
//                'line' => $e->getLine(),
//                'previous' => $e->getPrevious(),
//                //'severity' => 0,
//                //'string' => $e->getTraceAsString(),
//            ]);
//        }

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
//        if ($e instanceof \ErrorException) {
//            if($request->ajax()){
//                return api_false_response($e->getMessage(), $e->getCode());
//            }
//
//        }
//        if ($e instanceof NotFoundHttpException) {
//            if($request->ajax()){
//                return api_false_response('404 Page Not Found', 404);
//            }
//        }

        return parent::render($request, $e);
    }
}
