<?php

namespace App\Http\Middleware;

use AlphaEyeCore\Utils\AuthUtils;
use Closure;
use Tymon\JWTAuth\JWTAuth;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  AuthUtils  $auth
     * @return void
     */
    public function __construct(AuthUtils $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->check()) {
            if ($request->ajax()) {
                return response()->json('Unauthorized');
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }

        return $next($request);
    }
}
