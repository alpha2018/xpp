<?php namespace Core\Http\Middleware;

use Closure;

class EnableCorsMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 执行动作
        if($request->ajax()){
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept, Authorization');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'false');  //true Access-Control-Allow-Origin 不能指定为 *
            //HTTP响应头，用在响应预检请求上，表示本次预检响应的有效时间。
            //在此时间内，浏览器都可以根据此次协商结果决定是否有必要直接发送真实请求，而无需再次发送预检请求。
            $response->header('Access-Control-Max-Age', 2592000);
        }

        return $response;
    }
}