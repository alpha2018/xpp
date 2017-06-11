<?php namespace AlphaEyeCore\Utils;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

    }

    public static function user()
    {

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
        return $valu = $this->cache->get($this->getCacheKey($token));
    }

    protected function getCacheMinutes()
    {
        return $refresh_ttl = config('jwt.refresh_ttl');
    }

    protected function getCacheKey($token)
    {
        return md5($token);
    }


    public function setToken($user, $request)
    {
        $token = $this->JWTAuth->fromUser($user);
        $this->setAuthCache($token, $user, $request);

        return $token;
    }

    public function check($token)
    {
        $user = $this->JWTAuth->toUser($token);
        $valu  = $this->getAuthCache($token);
        if(empty($user)){
            return false;
        }

        return true;
    }

    public function setUser()
    {

    }

    public function getUser()
    {

    }
}