<?php namespace Core\Http\Middleware;
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 17/3/15
 * Time: 下午3:21
 */
class TerminateMiddleware
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        //todo
    }
}