<?php namespace AlphaEyeCore\Utils;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2017/6/9
 * Time: 下午6:45
 */
class AuthUtils
{
    protected $JWTAuth;
    protected $cache;
    protected $user;
    protected $auth;

    public function __construct(JWTAuth $JWTAuth, CacheManager $cache)
    {
        $this->JWTAuth = $JWTAuth;
        $this->cache = $cache;
    }

    public static function auth()
    {
        return $GLOBALS['jwt_auth'];
    }

    public static function user()
    {
        return $GLOBALS['jwt_auth']['user'];
    }

    protected function setAuth($user, Request $request)
    {
        $auth = array(
            'user' => $user,
            'ip'=>$request->getClientIp(),
            'user-agent'=>$request->header('user-agent'),
        );

        return $auth;
    }

    protected function resetAuth($user, $request)
    {
        return $this->setAuth($user, $request);
    }

    protected function setAuthCache($token, $user, $request)
    {
        $minutes = $this->getCacheMinutes();
        $cacheKey = $this->getCacheKey($token);
        $value = $this->setAuth($user, $request);
        $this->cache->put($cacheKey, $value, $minutes);

        return $value;
    }

    protected function getAuthCache($token)
    {
        return $this->cache->get($this->getCacheKey($token));
    }

    protected function getCacheMinutes()
    {
        return $refresh_ttl = config('jwt.refresh_ttl');
    }

    protected function getCacheKey($token)
    {
        return md5($token);
    }


    /**
     * 设置token
     * @param $user
     * @param $request
     * @return string
     */
    public function setToken($user, $request)
    {
        $token = $this->JWTAuth->fromUser($user);
        $this->setAuthCache($token, $user, $request);

        return $token;
    }

    /**
     * token认证
     * @param $token
     * @return bool
     */
    public function check($token)
    {
        $user = $this->JWTAuth->toUser($token);
        $auth  = $this->getAuthCache($token);
        //todo ip和浏览器验证
        if(true){

        }

        if(empty($user)){
            return false;
        }

        $GLOBALS['jwt_auth'] = $auth;
        return true;
    }

    public function setUser()
    {

    }

    public function getUser()
    {

    }

    /**
     * Retreiving the Authenticated user from a token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getAuthenticatedUser($token)
    {
        try {
            if(! $user = $this->JWTAuth->toUser($token)){
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    protected function invalidate($token)
    {
        return $this->JWTAuth->invalidate($token);
    }
}