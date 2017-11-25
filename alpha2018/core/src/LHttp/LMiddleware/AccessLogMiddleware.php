<?php namespace AlphaCore\LHttp\LMiddleware;
use App\Models\AccessLog;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/6/25
 * Time: 22:04
 */
class AccessLogMiddleware
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        //todo
        $accessLog = app(AccessLog::class);
        \Log::debug('1', [$request->ip()]);
        $accessLog->ip = $request->ip();
        $accessLog->save();
    }
}
