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
        if ($this->shouldReport($e)) {
//            # 解压PHP Log SDK后将BaeLog.class.php放在合适的位置
//            # /<Path_Prefix>为BaeLog.class.php的相对路径
//            require_once dirname(__FILE__) . '../../alphaeye/sdk/baev3-sdk-1.0.1/BaeLog.class.php';
//
//            $secret = array("user"=>"ak","passwd"=>"sk" );
//            $log = \BaeLog::getInstance($secret);
//            $log->setLogLevel(16);
//            $log->Fatal("fatal log test");
//            $log->Warning("Warning log test");
//            $log->Notice("Notice log test");
//            $log->Trace("Trace log test");
//            $log->Debug("Debug log test");
        }

        return parent::report($e);
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
